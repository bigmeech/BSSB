<?php
/**
 * Created by PhpStorm.
 * User: laggie
 * Date: 17/11/13
 * Time: 13:15
 */

class BioData extends Eloquent{

    protected $table="biodata";
    protected $primaryKey="user_id";

    public function user()
    {
        return $this->belongs_to('User');
    }


} 