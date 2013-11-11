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
		if(Auth::attempt(array('email' => Input::json('username'), 'password' => Input::json('password'))))
        {
            return Response::json(Auth::user());
        }
        else
        {
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
            'password' =>'required',
            'full_name'=>'required'
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

        $password=$input['password'];
        $password=Hash::make($password);

        $newUser=new User;
        $newUser->email=$input['email'];
        $newUser->password=$password;
        $newUser->full_name=$input['full_name'];
        $newUser->save();
        $newUser->applicant_id=$newUser->generateApplicantId($newUser->id);
        $newUser->save();
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