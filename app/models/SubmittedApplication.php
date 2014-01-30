<?php
/**
 * Created by PhpStorm.
 * User: ebirulz
 */

class SubmittedApplication extends Eloquent{
    protected $table = "submitted_application";
    protected $primaryKey = "user_id";

    public function user()
    {
        return $this->belongs_to('User');


    }
} 