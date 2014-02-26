<?php

use \Illuminate\Support\Facades\Response;
class ApplicantController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

    public function fetchFormCompleteData()
    {
        $form_comp_data = FormCompleteData::find(Input::all()['user_id']);
        if(is_null($form_comp_data))
        {
            $form_comp_data=new FormCompleteData();
            $form_comp_data->user_id = Input::all()['user_id'];
            $form_comp_data->save();
            return Response::json(
                array(
                    "warning"=>"emptydata"
                ),200
            );
        }
        else{
            return Response::json($form_comp_data,200);
        }
    }

    public function fetchAppData()
    {
        $appdata = ApplicationData::find(Input::all()['user_id']);//where('user_id','=',Input::all()['user_id'])->first();
        $scholarship = Scholarship::find(Input::all()['user_id']);
        if(!is_null($appdata))
        {
            if(!is_null($scholarship))
            {
                $appdata['reg_id'] = $scholarship->reg_number;
            }
            return Response::json($appdata,200);
        }
        else
        {
            $appdata = new ApplicationData;
            $appdata->user_id = Input::all()['user_id'];
            $appdata->save();

            return Response::json(
                array(
                    "Warning"=>"No application data exist for this user"
                )
            );
        }
    }

    public function fetchPreview()
    {
        $scholarship = Scholarship::find(Input::all()['user_id']);//where('user_id','=',Input::all()['user_id'])->first();
        $biodata = BioData::find(Input::all()['user_id']);//where('user_id','=',Input::all()['user_id'])->first();
        $basicQualification = BasicQualifications::find(Input::all()['user_id']);//where('user_id','=',Input::all()['user_id'])->first();
        $higher_inst = HigherInst::find(Input::all()['user_id']);//where('user_id','=',Input::all()['user_id'])->first();
        $profquali = ProfQualifications::find(Input::all()['user_id']);//where('user_id','=',Input::all()['user_id'])->first();

        $previewData = new stdClass();
        $previewData -> scholarship = $scholarship ? $scholarship -> toArray(): null;
        $previewData -> bioData = $biodata ? $biodata -> toArray(): null;
        $previewData -> basicQualifications = $basicQualification ? $basicQualification -> toArray() : null;
        $previewData -> profquali = $profquali ? $profquali -> toArray() : null;
        $previewData -> higherInst = $higher_inst ? $higher_inst -> toArray() : null;

        return Response::json($previewData,200);
    }

    public function fetchApplication()
    {
        $scholship=Scholarship::where('user_id','=',Input::get('user_id'))->first();
        if(!is_null($scholship))
        {
            return Response::json(
                array(
                    "user_id"=>$scholship->user_id,
                    "reg_number"=>$scholship->reg_number,
                    "course_of_study"=>$scholship->course_of_study,
                    "scholarship_type"=>$scholship->scholarship_type,
                    "government_bounded"=>$scholship->government_bounded,
                    "already_in_school"=>$scholship->already_in_school,
                    "has_admission"=>$scholship->has_admission,
                    "essay_url"=>$scholship->essay_url
                )
            );
        }
        else{
            return Response::json(
                array('warning'=>"You be JJC!!")
            );
        }
    }
    public function fetchBioData()
    {
        $biodata=BioData::where('user_id','=',Input::all()['user_id'])->first();
        if(!is_null($biodata))
        {
            return Response::json($biodata,200);
        }
        else{
            return Response::json(
                array('warning'=>"Bio Data is Empty")
            );
        }
    }

    public function fetchBasicQualifications()
    {
        $basicQualification=BasicQualifications::where('user_id','=',Input::all()['user_id'])->first();
        if(!is_null($basicQualification))
        {
            return Response::json($basicQualification,200);
        }
        else{
            return Response::json(
                array('Warning'=>"basic Qualification details for this user Does not Exist")
                ,200);
        }
    }

    public function fetchHigherInst()
    {
        $higher_inst=HigherInst::where('user_id','=',Input::all()['user_id'])->first();
        if(!is_null($higher_inst))
        {
            return Response::json($higher_inst,200);
        }
        else
        {
            return Response::json(
                array('Warning'=>'Higher Institution details for this user does not exist yet')
                ,200);
        }
    }

    public function fetchProfQuali()
    {
        $prof_quali=ProfQualifications::where('user_id','=',Input::all()['user_id'])->first();
        if(!is_null($prof_quali))
        {
            return Response::json($prof_quali,200);
        }
        else
        {
            return Response::json(
                array('Warning'=>'Higher Institution details for this user does not exist yet')
                ,200);
        }
    }


    public function saveStartApp()
    {
        $input=Input::all();
        $scholarship=Scholarship::where('user_id','=',$input['user_id'])->first();
        $appData=ApplicationData::where('user_id','=',$input['user_id'])->first();
        $form_comp_data = FormCompleteData::find(Input::all()['user_id']);
        //checks to see if user already has scholaship details and return the details if they exist,
        //if it doesnt exist, it inserts a new row in the database with
        //return var_dump($appData);
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
            $scholarship=new Scholarship();
            $scholarship->user_id=$input['user_id'];
            $scholarship->reg_number=$scholarship->generateRegNumber($input['user_id'],$input['scholarship_type']['name']);
            $scholarship->scholarship_type=$input['scholarship_type']['name'];
            $scholarship->course_of_study=$input['course_of_study'];
            $scholarship->government_bounded=$input['ready_to_bound']=='YES'?'YES':'NO';
            $scholarship->already_in_school=$input['already_in_school']=='YES'?'YES':'NO';
            $scholarship->has_admission=$input['has_an_admission']=='YES'?'YES':'NO';
            $scholarship->essay_url=$input['path_to_essay'];
            $scholarship->push();

            $form_comp_data->scholarship_app_completed = "1";
            $form_comp_data->save();

            $appData->app_progress = 20 + $appData->app_progress;
            $appData->save();
            return Response::json(
                array("Message"=>"Just added New stuff")
            );
        }
    }

    public function addBioData()
    {
        $client=Input::all();
        $db = BioData::where('user_id','=',$client['user_id'])->first();
        $appData = ApplicationData::find(Input::all()['user_id']);
        $form_comp_data = FormCompleteData::find(Input::all()['user_id']);

        if(is_null($db))
        {
            $db=new BioData;
            foreach($client as $key => $value)
            {

                if(is_array($value))
                {
                    //var_dump($value['value']);
                    $db->$key=$value['value'];
                }
                else
                {
                    $db->$key=$value;
                }
            }
            $db->save();
            $appData->app_progress = 20 + $appData->app_progress;
            $appData->save();

            $form_comp_data->biodata_completed = "1";
            $form_comp_data->save();

            return Response::json(array('warning'=>'Adding new stuff'));
        }
        else
        {
            foreach($client as $key => $value)
            {
                if(is_array($value))
                {
                    //var_dump($value['value']);
                    $db->$key=$value['value'];
                }
                else
                {
                    $db->$key=$value;
                }
            }
            $db->save();
            return Response::json(array('Warning'=>'Updating old stuff'));
        }

    }

    public function addQualificationDetails()
    {
        $client=(object)Input::all();
        $db = BasicQualifications::where('user_id','=',$client->user_id)->first();
        $appData = ApplicationData::find(Input::all()['user_id']);
        $form_comp_data = FormCompleteData::find(Input::all()['user_id']);

        if(!is_null($db))
        {
            foreach($client as $key => $value)
            {
                if(is_array($value))
                    $db->$key=$value['name'];
                else
                   $db->$key=$value;
            }
            $db->save();
            return Response::json($db,200);
        }
        else{
            $db=new BasicQualifications;
            foreach($client as $key => $value)
            {
                if(is_array($value))
                    $db->$key=$value['name'];
                else
                    $db->$key=$value;
            }
            $db->save();
            $appData->app_progress = 20 + $appData->app_progress;
            $appData->save();

            $form_comp_data->basic_qualification_completed = "1";
            $form_comp_data->save();
            return Response::json($db,200);
        }

    }

    public function addHigherInstDetails()
    {
        $client=(object)Input::all();
        $db=HigherInst::where('user_id','=',$client->user_id)->first();
        $appData = ApplicationData::find(Input::all()['user_id']);
        $form_comp_data = FormCompleteData::find(Input::all()['user_id']);

        if(is_null($db))
        {
            $db=new HigherInst;
            foreach($client as $key => $value)
            {
                if(is_array($value)){
                    $db->$key=$value['value'];
                }
                else{
                    $db->$key=$value;
                }
            }
            $db->save();
            $appData->app_progress = 20 + $appData->app_progress;
            $appData->save();

            $form_comp_data->higher_institution_completed = "1";
            $form_comp_data->save();

            return Response::json(array('warning'=>'Adding new stuff'));
        }
        else
        {
            foreach($client as $key => $value)
            {
                if(is_array($value)){
                    $db->$key=$value['value'];
                }
                else{
                    $db->$key=$value;
                }
            }
            $db->save();
            return Response::json(array('Warning'=>'Updating old stuff'));
        }
    }

    public function addProfQuali()
    {
        $client=(object)Input::all();
        $db=ProfQualifications::where('user_id','=',$client->user_id)->first();
        $appData = ApplicationData::find(Input::all()['user_id']);
        $form_comp_data = FormCompleteData::find(Input::all()['user_id']);

        if(is_null($db))
        {
            $db=new ProfQualifications;
            foreach($client as $key => $value)
            {
                $db->$key=$value;
            }
            $db->save();

            $appData->app_progress = 20 + $appData->app_progress;
            $appData->save();

            $form_comp_data -> professionbal_qualification_completed = "1";
            $form_comp_data->save();
            return Response::json(array('warning'=>'Adding new stuff'));
        }
        else
        {
            foreach($client as $key => $value)
            {
                $db->$key=$value;
            }
            $db->save();
            return Response::json(array('Warning'=>'Updating old stuff'));
        }
    }

    public function submitApplication()
    {

        $user_id=Input::all()['user_id'];
    	$submit_table = new SubmittedApplication;
        if(is_null(SubmittedApplication::find($user_id))){
            $submit_table->user_id=$user_id;
            $submit_table->save();
            return Response::json(array(
                "operation"=>"submit",
                "message"=>"Your application has been tended in successfully",
                "success"=>"true"
            ),200);
        }
        else{
            return Response::json(array(
                "operation"=>"submit",
                "message"=>"Application has already been submitted",
                "success"=>"false"
            ),406);
        }

    }

}