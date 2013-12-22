<?php

use Illuminate\Support\Facades\Hash;
class AuthController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function login()
	{
		if(Auth::attempt(array('email' => Input::json('username'), 'password' => Input::json('password')))){
            return Response::json(Auth::user());
        }else{
            return Response::json(array('flash' => 'Invalid Username or Password Supplied'),500);
        }
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function logout()
	{
        Auth::logout();
        return Response::json(array('flash' =>'User Logged Out'));
	}

	public function signup()
	{
        $input=Input::all();
        $rules=array(
            'email'=>'required|unique:users|email',
            'firstname'=>'required',
            'lastname'=>'required'
        );

        $v=Validator::make($input,$rules);
        if($v->fails())
        {
            return Response::json(
                array(
                    'error'=>'Incomplete form data',
                    'message'=>$v->messages()->first('email')
            ),400);
        }

        $newUser=new User;
        $newUser->email=$input['email'];
        $temp_password=$newUser->generateRandomPass();
        $newUser->password=Hash::make($temp_password);
        $newUser->firstname=$input['firstname'];
        $newUser->lastname=$input['lastname'];
        $newUser->save();

        //send email

        Mail::send('welcome',
            array('email'=>$newUser->email,'firstname'=>$newUser->firstname,'lastname'=>$newUser->lastname,'temp_pass'=>$temp_password),
            function($message) use ($newUser)
            {
            $message->to($newUser->email,$newUser->full_name)->subject('Your BSSB Account!');
        });
        return Response::json($newUser,200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}