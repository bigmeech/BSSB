<?php

class appController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		//$biodata = BioData::all();
        //return Response::json($biodata);

        $scholarship = Scholarship::all();
        $biodata = BioData::all();
        $highinst = HigherInst::all();

        $allApplicantData = new stdClass();
        $allApplicantData -> scholarship = $scholarship ? $scholarship -> toArray(): null;
        $allApplicantData -> bioData = $biodata ? $biodata -> toArray(): null;
        $allApplicantData -> higherInst = $highinst ? $highinst -> toArray() : null;

        return Response::json($allApplicantData,200);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$scholarship = Scholarship::find(Input::all()['user_id']);
                $biodata = BioData::find(Input::all()['user_id']);
                $highinst = HigherInst::find(Input::all()['user_id']);

                 $singleApplicant = new stdClass();
                 $singleApplicant -> scholarship = $scholarship ? $scholarship -> toArray(): null;
                 $singleApplicant -> bioData = $biodata ? $biodata -> toArray(): null;

                 return Response::json(
                                 array(

                                     "reg_number"=>$singleApplicant->reg_number,
                                     "First Name"=>$singleApplicant->firstName,
                                     "Surname"=>$singleApplicant->surname,
                                     "Scholarship type"=>$singleApplicant->scholarship_type,
                                     "Grade"=>$singleApplicant->inst1_grade,
                                     "L.G.A"=>$singleApplicant->mLGA

                                 )
                             );
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
