<?php
/**
 * Created by PhpStorm.
 * User: laggie
 * Date: 27/10/13
 * Time: 02:29
 */
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder{

    public function run()
    {
        DB::table('users')->delete();
        $users=array(
            array(
                'email'    => 'denachural@gmail.com',
                'type' => 'applicant',
                'firstname' => 'Larry',
                'lastname'  => 'Eliemenye',
                'password' => Hash::make('Opensesamie85'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            )
        );
        $adminUser=array(
            'email'    => 'admin@bssb-gov.com',
            'type' => 'admin',
            'firstname' => 'admin',
            'lastname'  => 'admin',
            'password' => Hash::make('admin'),
            'created_at' => new DateTime,
            'updated_at' => new DateTime
        );

        DB::table('users')->insert($adminUser);
        DB::table('users')->insert($users);
    }

} 