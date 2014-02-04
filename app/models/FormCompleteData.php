<?php
/**
 * Created by PhpStorm.
 * User: laggie
 * Date: 24/01/14
 * Time: 00:59
 */

class FormCompleteData extends Eloquent{

    protected $table="form_complete";
    protected $primaryKey="user_id";

    public function user()
    {
        return $this->belongs_to('User');
    }
} 