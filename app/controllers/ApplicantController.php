<?php

use \Illuminate\Support\Facades\Response;
class ApplicantController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

    public function fetchApplication()
    {
        $scholarship=Scholarship::where('user_id','=',Input::get('user_id'))->first();
        return Response::json(
            array(
                "user_id"=>$scholarship->user_id,
                "reg_number"=>$scholarship->reg_number,
                "course_of_study"=>$scholarship->course_of_study,
                "scholarship_type"=>$scholarship->scholarship_type,
                "government_bounded"=>$scholarship->government_bounded,
                "already_in_school"=>$scholarship->already_in_school,
                "has_admission"=>$scholarship->has_admission,
                "essay_url"=>$scholarship->essay_url
            )
        );
    }
	public function handleEssayFileUpload()
    {

        if(Input::hasFile('file'))
        {
            $files=Input::file('file');
            $destination=$files->move('uploads\essays',$files->getClientOriginalName());
            return Response::json(
                array(
                    'message'=>$files->getClientOriginalName()." successfully uploaded to ".$destination,
                    'filepath'=>''.$destination
                ),200);
        }
        else
        {
           return Response::json(array('error'=>'Not Uploaded'),406);
        }

    }

    public function saveStartApp()
    {
        $input=Input::all();
        $scholarship=Scholarship::where('user_id','=',$input['user_id'])->first();

        //checks to see if user already has schoolaship details and return the details if they exist,
        //if it doesnt exist, it inserts a new row in the database with
        if(!is_null($scholarship))
        {
            $essayfile_path=$scholarship->essay_url;
            $essayfile_name=new SplFileInfo($essayfile_path);
            $essayfile_name=$essayfile_name->getFilename();

            $scholarship->reg_number=$scholarship->generateRegNumber($input['user_id'],$input['scholarship_type']['name']);
            $scholarship->scholarship_type=$input['scholarship_type']['name'];
            $scholarship->course_of_study=$input['course_of_study'];
            $scholarship->government_bounded=$input['ready_to_bound']=='YES'?'YES':'NO';
            $scholarship->already_in_school=$input['already_in_school']=='YES'?'YES':'NO';
            $scholarship->has_admission=$input['has_an_admission']=='YES'?'YES':'NO';
            $scholarship->essay_url=$input['path_to_essay'];
            $scholarship->save();
            return Response::json(
                array(
                    "user_id"=>$scholarship->user_id,
                    "reg_number"=>$scholarship->reg_number,
                    "course_of_study"=>$scholarship->course_of_study,
                    "scholarship_type"=>$scholarship->scholarship_type,
                    "government_bounded"=>$scholarship->government_bounded,
                    "already_in_school"=>$scholarship->already_in_school,
                    "has_admission"=>$scholarship->has_admission,
                    "essay_url"=>$essayfile_name

                ),200
            );
        }
        else{
            $scholarship=new Schoolarship;
            $scholarship->user_id=$input['user_id'];
            $scholarship->reg_number=$scholarship->generateRegNumber($input['user_id'],$input['scholarship_type']['name']);
            $scholarship->scholarship_type=$input['scholarship_type']['name'];
            $scholarship->course_of_study=$input['course_of_study'];
            $scholarship->government_bounded=$input['ready_to_bound']=='YES'?'YES':'NO';
            $scholarship->already_in_school=$input['already_in_school']=='YES'?'YES':'NO';
            $scholarship->has_admission=$input['has_an_admission']=='YES'?'YES':'NO';
            $scholarship->essay_url=$input['path_to_essay'];
            $scholarship->push();
            return Response::json(
                array("Message"=>"Just added New stuff")
            );
        }

        /**
        if(!$scholarship)
        {

        }


        $scholarship_to_client=Schoolarship::find($input['user_id']);

        return Response::json(
            array(
                "user_id"=>$scholarship_to_client->user_id,
                "regNumber"=>$scholarship_to_client->reg_number,
                "courseOfStudy"=>$scholarship_to_client->course_of_study,
                "scholarshipType"=>$scholarship_to_client->scholarship_type,
                "governmentBounded"=>$scholarship_to_client->government_bounded,
                "alreadyInSchool"=>$scholarship_to_client->already_in_school,
                "hasAdmission"=>$scholarship_to_client->has_admission,
                "essayUrl"=>$scholarship_to_client->essay_url
            ),200
        );
        **/
    }

}