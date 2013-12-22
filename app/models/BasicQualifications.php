<?php
/**
 * Created by PhpStorm.
 * User: laggie
 * Date: 19/11/13
 * Time: 01:03
 */

class BasicQualifications extends Eloquent{

    protected $table="basic_qualifications";
    protected $primaryKey="user_id";

    public function user()
    {
        return $this->belongs_to('User');
    }

} 