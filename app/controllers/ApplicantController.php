<?php
use \Symfony\Component\Finder\SplFileInfo;
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

}