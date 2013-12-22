<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

    public function scholarship()
    {
        return $this->hasOne('Scholarship');
    }

    public function generateApplicantId($id)
    {
        $date=new DateTime();
        $date=$date->getTimestamp();
        return "BSSB-".str_pad($id, 4, '0', STR_PAD_LEFT)."-". $date;
    }

    public function generateRandomPass()
    {
        $char_set="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXWY1234567890";
        $pass=array();
        $char_length = strlen($char_set) - 1;

        for($i = 0;$i<12;$i++)
        {
            $pick=rand(0,$char_length);
            $pass[]=$char_set[$pick];
        }

        return implode($pass);
    }

}