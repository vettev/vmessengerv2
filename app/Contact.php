<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Message;

class Contact extends Model
{
    /**
     * Get user whois saved in contact
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userSaved()
    {
    	return $this->belongsTo('App\User', 'saved_user');
    }

    /**
     * Gets owner of contact (who saved contact)
     * 
     * @return [type] [description]
     */
    public function userBelongs()
    {
    	return $this->belongsTo('App\User', 'belongs_to');
    }

    /**
     * Get count of unread message in conversation
     * 
     * @return int
     */
    public function getUnread()
    {
    	$userSaved = $this->userSaved()->first()->id;
        $userBelongs = $this->userBelongs()->first()->id;
    	
        return Message::where('sender_id', $userSaved)
        ->where('recipient_id', $userBelongs)
        ->where('displayed', 0)
        ->get()->count();
    }
}
