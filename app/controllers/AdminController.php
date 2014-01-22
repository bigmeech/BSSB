<?php
/**
 * Created by PhpStorm.
 * User: laggie
 * Date: 18/01/14
 * Time: 22:55
 */

use Illuminate\Support\Facades\Response;
class AdminController extends BaseController{

    public function index()
    {
        return Response::View('admin_login');
    }

    public function dashboard()
    {
        return Response::view('admin_main');
    }
} 