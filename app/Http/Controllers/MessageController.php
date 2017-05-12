<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\User;
use App\Message;
use Auth;

class MessageController extends Controller
{

    private $pusher;

    /**
     * Constructor, make pusher
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->pusher = App::make('pusher');
    }

    /**
     * Store message in database and send to recipient
     * 
     * @param  Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function newMessage(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'recipient_id' => 'required'
        ]);

        if($request->recipient_id == Auth::user()->id) {
            return response("You can't message self", 406);
        }

        $message = new Message();
        $message->content = $request->content;
        $message->recipient_id = $request->recipient_id;
        $message->sender_id = Auth::user()->id;
        $message->save();

        return response()->json(['created_at' => $message->created_at->format('H:i')]);
    }

    /**
     * Get conversation window
     * 
     * @param  int $recipient_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function newConversation($recipient_id)
    {
    	$recipient = User::find($recipient_id);
    	$messages = Message::where([
    		'recipient_id' => $recipient_id,
    		'sender_id' => Auth::user()->id
    	])
    	->orWhere([
    		'recipient_id' => Auth::user()->id,
    		'sender_id' => $recipient_id
    	])
        ->orderBy('created_at', 'desc')
        ->limit(50)
        ->get()->reverse();

        $users = [$recipient_id => User::find($recipient_id), Auth::user()->id => Auth::user()];
        Message::where(['recipient_id' => Auth::user()->id, 'sender_id' => $recipient_id, 'displayed' => 0])->update(['displayed' => 1]);

    	return view('layouts.conversation', compact('recipient_id', 'messages', 'users'));
    }

    /**
     * Trigger message to client
     * 
     * @param  Request $request
     */
    public function triggerMessage(Request $request)
    {
        $channelName = "private-user-".$request->recipient_id;
        $data = [
            'sender' => Auth::user()->name,
            'sender_id' => Auth::user()->id,
            'content' => $request->content,
            'created_at' => $request->created_at
        ];
        $this->pusher->trigger($channelName, 'message', $data);
    }

    /**
     * Returns not displayed messages from strangers
     * 
     * @return \Illuminate\Http\Response
     */
    public function unreadMessages()
    {
        $messages = Message::where(['displayed' => 0, 'recipient_id' => Auth::user()->id])->cursor();

        $user_ids = [];
        $users = [];

        foreach($messages as $message)
        {
            if(!in_array($message->sender_id, $user_ids))
                $user_ids[] = $message->sender_id;
        }
        foreach($user_ids as $id)
        {
            $users[] = User::find($id);
        }
        $users = array_filter($users, function($id) {
            return (Auth::user()->hasContact($id));
        });

        return view('layouts.unread', compact('users'));
        
    }

    /**
     * Mark messages as read from controller
     * 
     * @param  Request $request
     * @return void
     */
    public function markAsRead(Request $request)
    {
        $this->validate($request, [
            'recipient_id' => 'required'
            ]);

        if(!User::find($request->recipient_id))
            return response('No user with that ID', 404);

        Auth::user()->markAsRead($request->recipient_id);
    }
}
