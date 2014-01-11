<?php

class FileController extends BaseController {

	const ESSAY_FILE_TYPE = "essay";
    const JAMB_FILE_TYPE = "jamb";
    const O_LEVEL_SITTING_1 = "sitting1";
    const O_LEVEL_SITTING_2 = "sitting2";
    const A_LEVEL_FILE_TYPE = "aLevels";
    const JAMB_CERT_FILE_TYPE = "jamb";
    const INST_1_CERT = "inst1";
    const INST_2_CERT = "inst2";
    const NYSC_CERT = "nysc";
    const PROF_QUALI1_CERT = "prof1_cert";
    const PROF_QUALI2_CERT = "prof2_cert";
    const PASSPORT_PHOTO = "passportPhoto";


    function uploadFileByType($files,$type,$user_id)
    {

        $uploadPath='public\uploads\\'.$user_id.'\\'.$type;
        if(file_exists($uploadPath))
        {
            foreach (scandir($uploadPath) as $item) {
                if ($item == '.' || $item == '..') continue;
                unlink($uploadPath.DIRECTORY_SEPARATOR.$item);
            }
        }
        //move file from temp to physical path
        $destination=$files->move($uploadPath,$files->getClientOriginalName());
        $real_path = $destination->getPath()."\\".$destination->getFilename();;
        $url = substr($real_path,7);

        //if file was uploaded sucessfully
        if($destination)
        {
            if($destination->getSize() > 5242880)
            {
                return Response::json(
                    array(
                        "error"=>"FileUploadError",
                        "message"=>"The File is to big, must be maximum of 8MB"
                    ),406
                );
            }
            if($destination->getExtension() !== "JPG" && $destination->getExtension() !== "jpg")
            {
                if($destination->getExtension() !== "doc" && $destination->getExtension() !== "docx" && $type === FileController::ESSAY_FILE_TYPE)
                {
                    return Response::json(
                        array(
                            "error"=>"FileUploadError",
                            "message"=>"Invalid file type, must be a microsoft word document ending with .doc or .docx"
                        ),406
                    );
                }
                else
                {
                    return Response::json(
                        array(
                            "filename"=>$destination->getFileName(),
                            "filepath"=>$destination->getRealPath(),
                            "url"=>''.asset($url),
                            "type"=>$type
                        ),200);
                }
            }
            else{
                return Response::json(
                    array(
                        "filename"=>$destination->getFileName(),
                        "filepath"=>$destination->getRealPath(),
                        "url"=>''.asset($url),
                            "type"=>$type
                    ),200);
            }


        }
        else{
            return Response::json(
                array(
                    'Error'=>'Could Not Upload File'
                ),400);
        }

    }


    function uploadFile()
    {

        $user_id=Input::get("user_id");
        $file_type=Input::get('file_type');
        if(Input::hasFile('file'))
        {
            $files=Input::file('file');
            $size=$files->getSize();
            $extension=$files->getExtension();
            switch($file_type)
            {
                case FileController::ESSAY_FILE_TYPE:
                     return $this->uploadFileByType($files,FileController::ESSAY_FILE_TYPE,$user_id);
                     break;
                case FileController::O_LEVEL_SITTING_1:
                    return $this->uploadFileByType($files,FileController::O_LEVEL_SITTING_1,$user_id);
                    break;
                case FileController::O_LEVEL_SITTING_2:
                    return $this->uploadFileByType($files,FileController::O_LEVEL_SITTING_2,$user_id);
                    break;
                case FileController::A_LEVEL_FILE_TYPE:
                    return $this->uploadFileByType($files,FileController::A_LEVEL_FILE_TYPE,$user_id);
                    break;
                case FileController::JAMB_CERT_FILE_TYPE:
                    return $this->uploadFileByType($files,FileController::JAMB_CERT_FILE_TYPE,$user_id);
                    break;
                case FileController::INST_1_CERT:
                    return $this->uploadFileByType($files,FileController::INST_1_CERT,$user_id);
                    break;
                case FileController::INST_2_CERT:
                    return $this->uploadFileByType($files,FileController::INST_2_CERT,$user_id);
                    break;
                case FileController::NYSC_CERT:
                    return $this->uploadFileByType($files,FileController::NYSC_CERT,$user_id);
                    break;
                case FileController::PROF_QUALI1_CERT:
                    return $this->uploadFileByType($files,FileController::PROF_QUALI1_CERT,$user_id);
                    break;
                case FileController::PROF_QUALI2_CERT:
                    return $this->uploadFileByType($files,FileController::PROF_QUALI2_CERT,$user_id);
                    break;
                case FileController::PASSPORT_PHOTO:
                    return $this->uploadFileByType($files,FileController::PASSPORT_PHOTO,$user_id);
                    break;
                default:
                    return Response::json(array('Error'=>'Unrecognised Scholarship File'),406);
                    break;
            }
        }
        else{
            return Response::json(array('error'=>'Not Uploaded'),406);
        }

    }

}