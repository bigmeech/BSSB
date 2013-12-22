<?php
/**
 * Created by PhpStorm.
 * User: laggie
 * Date: 26/11/13
 * Time: 13:16
 */

class ProfQualifications extends Eloquent{

    protected $table = "prof_quali";
    protected $primaryKey = "user_id";

    public function user()
    {
        return $this->belongs_to('User');

    }
} 