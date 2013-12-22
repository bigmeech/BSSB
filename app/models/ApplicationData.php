<?php
/**
 * Created by PhpStorm.
 * User: laggie
 * Date: 16/12/13
 * Time: 19:45
 */

class ApplicationData extends Eloquent{

    protected $table = "application_data";
    protected $primaryKey = "user_id";

    public function user()
    {
        return $this->belongs_to('User');
    }
} 