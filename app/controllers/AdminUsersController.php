<?php

class AdminUsersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $users = User::all();
		return Response::json($users,200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $user = new User;
        $user->type = Input::all()['type'];
        $user->email = Input::all()['email'];
        $user->password = Hash::make(Input::all()['password']);
        $user->lastname = Input::all()['lastname'];
        $user->firstname = Input::all()['firstname'];
        $id = $user->save();

        if(isset($id))
        {
            return Response::json(array(
                "user_id"   =>$id,
                "operation" =>"create user",
                "sucess"    =>true
            ),200);
        }
        else{
            return Response::json(array(
                "user_id"   =>$id,
                "operation" =>"create user",
                "sucess"    =>false
            ),418);
        }

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        return Response::json(array(
            "user"=>"wwhhhaaattt"
        ),200);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        //return Input::all()['name'];
        $user =User::where('lastname','LIKE',"%".Input::all()['name']."%")->get();
        return Response::json($user,200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return Response::json(array(
            "user"=>"wwhhhaaattt"
        ),200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        return Response::json(array(
            "user"=>"wwhhhaaattt"
        ),200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $affected_user_id=User::where("id",'=',$id)->delete();
        if($affected_user_id>0)
        {
            return Response::json(array(
                "user_id"=>$affected_user_id,
                "operation"=>"delete",
                "sucess"=>true
            ),200);
        }
        else{
            return Response::json(array(
                "user_id"=>$id,
                "operation"=>"delete",
                "sucess"=>false
            ),404);
        }

	}

}