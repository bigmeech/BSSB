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
        $profQualification = ProfQualifications::all();

        $allApplicantData = new stdClass();
        $allApplicantData -> scholarship = $scholarship ? $scholarship -> toArray(): null;
        $allApplicantData -> bioData = $biodata ? $biodata -> toArray(): null;
        $allApplicantData -> higherInst = $highinst ? $highinst -> toArray() : null;
        $allApplicantData -> profQualification = $profQualification ? $profQualification -> toArray() : null;

        //return Response::json($allApplicantData,200);
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
		        $scholarship = Scholarship::find($id);
                $biodata = BioData::find($id);
                $highinst = HigherInst::find($id);
                $profQualification = ProfQualifications::find($id);

                 $singleApplicant = new stdClass();
                 $singleApplicant -> scholarship = $scholarship ? $scholarship -> toArray(): null;
                 $singleApplicant -> bioData = $biodata ? $biodata -> toArray(): null;
                 $singleApplicant -> higherInst = $highinst ? $highinst -> toArray() : null;
                 $singleApplicant -> profQualification = $profQualification ? $profQualification -> toArray() : null;

                 return Response::json($singleApplicant,200);
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
