<?php
/**
 * Created by PhpStorm.
 * User: laggie
 * Date: 23/11/13
 * Time: 17:49
 */

class HigherInst extends Eloquent{
    protected $table = "higher_inst";
    protected $primaryKey = "user_id";

    public function user()
    {
        return $this->belongs_to('User');

    }
} 