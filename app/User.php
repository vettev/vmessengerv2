<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Message;
use App\Contact;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get contacts of user
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contacts()
    {
        return $this->hasMany('App\Contact', 'belongs_to');
    }

    /**
     * Get messages that user sent
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sent()
    {
        return $this->hasMany('App\Message', 'sender_id');
    }

    /**
     * Get messages that user received
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function received()
    {
        return $this->hasMany('App\Message', 'recipient_id');
    }

    /**
     * Check if user have other user in contacts
     * 
     * @param  int  $id
     * @return boolean
     */
    public function hasContact($id)
    {
        $contact = Contact::where(['belongs_to' => $this->id, 'saved_user' => $id])->count();
        if($contact === 1)
            return true;

        return false;
    }

    /**
     * Count of unread messages from strangers
     * 
     * @return int
     */
    public function unreadCount()
    {
        $messages = Message::where(['displayed' => 0, 'recipient_id' => $this->id])->cursor();

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
            return ($this->hasContact($id));
        });

        return count($users);
    }

    /**
     * Mark messages as read
     * 
     * @param  int $id
     * @return void
     */
    public function markAsRead($id)
    {
        $messages = Message::where(['displayed' => 0, 'recipient_id' => $this->id, 'sender_id' => $id]);

        $messages->update(['displayed' => 1]);
    }
}
