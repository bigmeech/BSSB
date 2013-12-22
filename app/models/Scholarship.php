<?php
/**
 * Created by PhpStorm.
 * User: laggie
 * Date: 12/11/13
 * Time: 01:36
 */

class Scholarship extends Eloquent{
    protected $table = 'scholarship';
    protected $primaryKey="user_id";

    public function user()
    {
        return $this->belongs_to('User');
    }

    public function generateRegNumber($user_id,$scholarship_type)
    {
        $currentyear=date("Y");
        return "BSSB/".$currentyear."/".$scholarship_type.str_pad($user_id, 4, '0', STR_PAD_LEFT);
    }
}