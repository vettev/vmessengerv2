<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Message extends Model
{
    /**
     * Make instance of Message class, set displayed property to false 
     */
	public function __construct()
	{
		$this->displayed = false;
	}

	protected $fillable = [ 'content', 'sender_id', 'recipient_id' ]; 

    /**
     * Gets sender of message
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
    	return $this->belongsTo('App\User', 'sender_id');
    }

    /**
     * Gets recipient of message
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recipient()
    {
    	return $this->belongsTo('App\User', 'recipient_id');
    }
}
