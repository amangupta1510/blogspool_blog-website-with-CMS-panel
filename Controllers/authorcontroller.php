<?php

namespace App\Http\Controllers;
use Validator;
use Response;
use File;
use Auth;
use Storage;
use PDF;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\http\Requests;
use Illuminate\Http\Request;
use App\admin;
use App\article;
use App\author;
use App\category;
use App\comment;
use App\contact;
use App\image_file;
use App\tag;
use DB;
use Geographical;
use Image;
use Excel;
use Carbon\Carbon;
use DateTime;

class authorcontroller extends Controller
{ 
  /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:author');
    }

    public function index(){
      return view('author.dashboard');
    }

    public function profile(){
      return view('author.profile');
    }

   
    










}
