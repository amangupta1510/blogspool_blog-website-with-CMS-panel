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

class admincontroller extends Controller
{ 
  /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(){
      return view('admin.dashboard');
    }

    public function profile(){
      return view('admin.profile');
    }

    public function edit_profile_submit(Request $request){
      $profile = admin::find(Auth::user()->id);
      $profile->username = $request->username;
      $profile->name = $request->name;
      $profile->email = $request->email;
      $profile->contact = $request->contact;
      $profile->address = $request->address;
      $profile->save();
      return redirect()->route('admin-dashboard');
    }

    public function change_password(){
      return view('admin.change_password');
    }

    public function change_password_submit(Request $request){  
      $old = Auth::user()->password;
      if(Hash::check($request->oldpassword,$old)){ 
            $inv = admin::where('id',Auth::user()->id)->update(['password'=> Hash::make($request->password2)]);
            return redirect()->route('admin-dashboard');
       }
       else{
       return back();
       }
    }

    public function author(){
      $authors = author::where(['active'=>'1'])->orderBy('id', 'DESC')->paginate(10);
      return view('admin.author',compact('authors'));
    }

    public function add_author(){
      return view('admin.add_author');
    }

    public function add_author_submit(Request $request){

                  $file = new author();
                  $file->username = $request->username;
                  $file->password=Hash::make($request->password);
                  $file->name=$request->name;
                  $file->mobile=$request->mobile;
                  $file->email=$request->email;
                  $file->address=$request->address;
                  $file->description=$request->description;
                  $file->article_cnt=0;
                  $file->active=1;
                  $file->save();
                return redirect()->route('author_list');
    }

    public function edit_author(Request $request){
      $data = author::where(['id'=>$request->get('id'),'active'=>'1'])->get();
      return view('admin.edit_author',compact('data'));
    }

    public function edit_author_submit(Request $request){

                  $file = author::find($request->id);
                  $file->username = $request->username;
                  if($request->password!=""){$file->password=Hash::make($request->password);}
                  $file->name=$request->name;
                  $file->mobile=$request->mobile;
                  $file->email=$request->email;
                  $file->address=$request->address;
                  $file->description=$request->description;
                  $file->save();
                return redirect()->route('author_list');
    }

    public function delete_author(Request $request){
      $data = author::where(['id'=>$request->get('id'),'active'=>'1'])->update(['active'=>0]);
      return back();
    }

    public function author_details(Request $request){

      return view('admin.author_details');
    }





    public function category(){
      $categories = category::where(['active'=>'1'])->orderBy('id', 'DESC')->paginate(10);
      return view('admin.category',compact('categories'));
    }

    public function add_category(){
      return view('admin.add_category');
    }

    public function add_category_submit(Request $request){

               $file = new category();
                  $file->category_name = $request->category_name;
                  $file->active=1;
                  $file->save();
                return redirect()->route('category_list');
    }

    public function edit_category(Request $request){
      $data = category::where(['id'=>$request->get('id'),'active'=>'1'])->get();
      return view('admin.edit_category',compact('data'));
    }

    public function edit_category_submit(Request $request){

                  $file = category::find($request->id);
                  $file->category_name = $request->category_name;
                  $file->save();
                return redirect()->route('category_list');
    }


    public function delete_category(Request $request){
      $data = category::where(['id'=>$request->get('id'),'active'=>'1'])->update(['active'=>0]);
      return back();
    }




    public function tag(){
      $tags = tag::where(['active'=>'1'])->orderBy('id', 'DESC')->paginate(10);
      return view('admin.tag',compact('tags'));
    }

    public function add_tag(){
      return view('admin.add_tag');
    }

    public function add_tag_submit(Request $request){

               $file = new tag();
                  $file->tag_name = $request->tag_name;
                  $file->active=1;
                  $file->save();
                return redirect()->route('tag_list');
    }

    public function edit_tag(Request $request){
      $data = tag::where(['id'=>$request->get('id'),'active'=>'1'])->get();
      return view('admin.edit_tag',compact('data'));
    }

    public function edit_tag_submit(Request $request){

                  $file = tag::find($request->id);
                  $file->tag_name = $request->tag_name;
                  $file->save();
                return redirect()->route('tag_list');
    }


    public function delete_tag(Request $request){
      $data = tag::where(['id'=>$request->get('id'),'active'=>'1'])->update(['active'=>0]);
      return back();
    }





    public function image(){
      $images = image_file::where(['active'=>'1'])->orderBy('id', 'DESC')->paginate(25);
      return view('admin.image',compact('images'));
    }

    public function add_image(){
      return view('admin.add_image');
    }

    public function add_image_submit(Request $request){
 
         $file = new image_file();
         $image = $request->file('img');
         $name = time().uniqid(rand()).'.'.$image->getClientOriginalExtension();
         $image_resize = Image::make($image->getRealPath());              
         $image_resize->resize(1280, 720);
         $image_resize->save(base_path().'/public_html/images/'.$name);
         $img='images/'.$name; 
         $file->url = $img;

                  $file->author_id = 0;
                  $file->author_name = 'Admin';
                  $file->active=1;
                  $file->save();
                return redirect()->route('image_list');
    }


    public function delete_image(Request $request){
      $data = image_file::where(['id'=>$request->get('id'),'active'=>'1'])->update(['active'=>0]);
      return back();
    }

    public function image_copy_address(Request $request){
      $data = image_file::where(['id'=>$request->get('id'),'active'=>'1'])->update(['active'=>0]);
      return back();
    }




    public function article(){
      $articles = article::where(['active'=>'1'])->orderBy('id', 'DESC')->paginate(10);
      return view('admin.article',compact('articles'));
    }

    public function upload_image_submit(Request $request)
     {
          $this->validate($request, [
                  'images' => 'required'
          ]);
          if($request->hasfile('images'))
           {
              foreach($request->file('images') as $file)
              {
                  $name=$file->getClientOriginalName();
                  $file_name = pathinfo($name, PATHINFO_FILENAME);
                  $path=base_path().'/public_html/user_images/';
                  $file->move($path,$name); 
       $img = new image_files();
       $img->author_id = Auth::user()->id;
       $img->author_name = Auth::user()->name;
       $img->url = 'user_images/'.$name;
       $img->active = "1";
       $img->save();
              }
           }
            return Response::json($file);
      }

      public function upload_image_list(Request $request){
       $data = image_files::where(['active'=>'1'])->get();
       return Response::json($data);
     }

public function ckeditor_upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
        
            $request->file('upload')->move(public_path('images'), $fileName);
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }

    public function add_article(){
      $categories = category::where(['active'=>'1'])->orderBy('category_name', 'asc')->get();
      $tags = tag::where(['active'=>'1'])->orderBy('tag_name', 'asc')->get();
      return view('admin.add_article',compact('categories','tags'));
    }

    public function add_article_submit(Request $request){
                  $dateinit = \Carbon\Carbon::parse($request->dateini);
                  $file = new article();
                  $image = $request->file('image');
                  $name = time().uniqid(rand()).'.'.$image->getClientOriginalExtension();
                  $destinationPath = base_path().'/public_html/images';
                  $image_resize = Image::make($image->getRealPath());              
                  $image_resize->resize(1280, 720);
                  $image_resize->save(base_path().'/public_html/images/'.$name);
                  $img='images/'.$name; 
                  $file->title = $request->title;
                  $file->description = $request->description;
                  $file->image = $img;
                  $file->meta_tag = $request->meta_tag;
                  $file->category_name = $request->category_name;
                  $file->meta_description = $request->meta_description;
                  $file->page_title = $request->page_title;
                  $file->tags = $request->tags;
                  $file->category_id = $request->category_id;
                  $file->content = $request->full_content;
                  $file->publish_time = $dateinit->format('d M Y');
                  $file->author_name = 'admin';
                  $file->author_id = 0;
                  $file->clicks=0;
                  $file->active=1;
                  $file->save();
                return Response::json('done');
    }

    public function edit_article(Request $request){
      $data = article::where(['id'=>$request->get('id'),'active'=>'1'])->get();
      $categories = category::where(['active'=>'1'])->orderBy('category_name', 'asc')->get();
      return view('admin.edit_article',compact('data','categories'));
    }

    public function edit_article_submit(Request $request){

              $file = article::find($request->id);

              if ($request->hasFile('image')) {
              $image = $request->file('image');
              $name = time().uniqid(rand()).'.'.$image->getClientOriginalExtension();
              $destinationPath = base_path().'/public_html/images';
              $image_resize = Image::make($image->getRealPath());              
              $image_resize->resize(160, 150);
              $image_resize->save(base_path().'/public_html/images/'.$name);
              $img='images/'.$name; 
              $file->image = $img;
              }

                  $file->title = $request->title;
                  $file->description = $request->description;
                  $file->meta_tag = $request->meta_tag;
                  $file->category_name = $request->category_name;
                  $file->meta_description = $request->meta_description;
                  $file->page_title = $request->page_title;
                  $file->tags = $request->tags;
                  $file->category_id = $request->category_id;
                  $file->content = $request->full_content;
                  $file->save();
                return redirect()->route('article_list');
    }


    public function delete_article(Request $request){
      $data = article::where(['id'=>$request->get('id'),'active'=>'1'])->update(['active'=>0]);
      return back();
    }

    public function article_details(Request $request){

      return view('admin.article_details');
    }




    // public function order(){
    //   $orders = order::where(['active'=>'1'])->orderBy('id', 'DESC')->paginate(10);
    //   return view('admin.order',compact('orders'));
    // }

    // public function add_order(){
    //   $products = product::where(['active'=>'1'])->select('id','name','image','mrp','discount','price')->get();
    //   $distributers = distributer::where(['active'=>'1'])->get();
    //   return view('admin.add_order',compact('products','distributers'));
    // }

    // public function get_lot(Request $request){
    //   $lot = lot_entry::where(['p_id'=>$request->get('id'),'active'=>'1'])->get();
    //   return Response::json($lot);
    // }
    // public function add_order_submit(Request $request){

    //    $file = new order();
    //    $file->order_no = 'FIG'.date("ymdHis");
    //    $file->p_id = $request->p_id;
    //    $file->p_name=$request->p_name;
    //    $file->lot_id=$request->lot_id;
    //    $file->lot_no=$request->lot_no;
    //    $file->d_id = $request->d_id;
    //    $file->d_name = $request->d_name;
    //    $file->d_email=$request->d_email;
    //    $file->d_contact=$request->d_contact;
    //    $file->d_address=$request->d_address;
    //    $file->unit_mrp=$request->unit_mrp;
    //    $file->unit_discount=$request->unit_discount;
    //    $file->unit_price=$request->unit_price;
    //    $file->total_mrp=$request->total_mrp;
    //    $file->total_discount=$request->total_discount;
    //    $file->special_discount=$request->special_discount;
    //    $file->total_price=$request->total_price;
    //    $file->total_unit=$request->total_unit;
    //    $file->selling_time=$request->selling_time;
    //    $file->payment_method=$request->payment_method;
    //    $file->payment_status=$request->payment_status;
    //    $file->active=1;
    //    $file->save();

    //    $file = lot_entry::find($request->lot_id);
    //    $file->sold_unit = $file->sold_unit + $request->total_unit;
    //    $file->remain_unit = $file->unit - $file->sold_unit;
    //    $file->save();

    //    $file = distributer::find($request->d_id);
    //    $file->purchase_unit = $file->purchase_unit + $request->total_unit;
    //    $file->save();

    //    $file = product::find($request->p_id);
    //    $file->sold_unit = $file->sold_unit + $request->total_unit;
    //    $file->available_unit = $file->available_unit - $request->total_unit;
    //    $file->save();
    //    return redirect()->route('admin-order');
    // }

    // public function edit_order(Request $request){
    //   $products = product::where(['active'=>'1'])->select('id','name','image','mrp','discount','price')->get();
    //   $distributers = distributer::where(['active'=>'1'])->get();
    //   $data = order::where(['id'=>$request->get('id'),'active'=>'1'])->get();
    //   foreach ($data as $dt) {
    //    $lots = lot_entry::where(['p_id'=>$dt->p_id,'active'=>'1'])->get();
    //   }
    //   return view('admin.edit_order',compact('data','products','distributers','lots'));
    // }

    // public function edit_order_submit(Request $request){

    //    $file = order::find($request->id);

    //    $files = lot_entry::find($file->lot_id);
    //    $files->sold_unit = $files->sold_unit - $file->total_unit;
    //    $files->remain_unit = $files->unit - $files->sold_unit;
    //    $files->save();

    //    $files = distributer::find($file->d_id);
    //    $files->purchase_unit = $files->purchase_unit - $file->total_unit;
    //    $files->save();

    //    $files = product::find($file->p_id);
    //    $files->sold_unit = $files->sold_unit - $file->total_unit;
    //    $files->available_unit = $files->available_unit + $file->total_unit;
    //    $files->save();

    //    $file->p_id = $request->p_id;
    //    $file->p_name=$request->p_name;
    //    $file->lot_id=$request->lot_id;
    //    $file->lot_no=$request->lot_no;
    //    $file->d_id = $request->d_id;
    //    $file->d_name = $request->d_name;
    //    $file->d_email=$request->d_email;
    //    $file->d_contact=$request->d_contact;
    //    $file->d_address=$request->d_address;
    //    $file->unit_mrp=$request->unit_mrp;
    //    $file->unit_discount=$request->unit_discount;
    //    $file->unit_price=$request->unit_price;
    //    $file->total_mrp=$request->total_mrp;
    //    $file->total_discount=$request->total_discount;
    //    $file->special_discount=$request->special_discount;
    //    $file->total_price=$request->total_price;
    //    $file->total_unit=$request->total_unit;
    //    $file->selling_time=$request->selling_time;
    //    $file->payment_method=$request->payment_method;
    //    $file->payment_status=$request->payment_status;
    //    $file->active=1;
    //    $file->save();

    //    $file = lot_entry::find($request->lot_id);
    //    $file->sold_unit = $file->sold_unit + $request->total_unit;
    //    $file->remain_unit = $file->unit - $file->sold_unit;
    //    $file->save();

    //    $file = distributer::find($request->d_id);
    //    $file->purchase_unit = $file->purchase_unit + $request->total_unit;
    //    $file->save();

    //    $file = product::find($request->p_id);
    //    $file->sold_unit = $file->sold_unit + $request->total_unit;
    //    $file->available_unit = $file->available_unit - $request->total_unit;
    //    $file->save();

       
    //    return redirect()->route('admin-order');
    // }

    // public function delete_order(Request $request){
    //   $file = order::find($request->id);

    //    $files = lot_entry::find($file->lot_id);
    //    $files->sold_unit = $files->sold_unit - $file->total_unit;
    //    $files->remain_unit = $files->unit - $files->sold_unit;
    //    $files->save();

    //    $files = distributer::find($file->d_id);
    //    $files->purchase_unit = $files->purchase_unit - $file->total_unit;
    //    $files->save();

    //    $files = product::find($file->p_id);
    //    $files->sold_unit = $files->sold_unit - $file->total_unit;
    //    $files->available_unit = $files->available_unit + $file->total_unit;
    //    $files->save();

    //    $file->active=0;
    //    $file->save();
    //   return back();
    // }


    // public function distributer_details(Request $request){

    //   return view('admin.distributer_details');
    // }
    // public function lot_details(Request $request){

    //   return view('admin.lot_details');
    // }

    //  public function balance_sheet_load(Request $request){
    //   if($request->get('type')=='all'){
    //   $orders = order::where(['active'=>'1'])->get();
    //     }else if($request->get('type')=='month'){
    //       $start = new DateTime();$start->modify('-6 month'); $start=$start->format('Y-m-d');
    //       $end = new DateTime();$end=$end->format('Y-m-d');
    //      $orders = order::where(['active'=>'1'])->whereBetween('created_at', [$start." 00:00:00",$end." 23:59:59"])->get();
    //     }
    //     else{
    //       $orders = order::where(['active'=>'1'])->whereBetween('created_at', [$request->get('start')." 00:00:00",$request->get('end')." 23:59:59"])->get();
    //     }
    //   return Response::json($orders);
    // }




    // public function product_details_load(Request $request){
    //   if($request->get('type')=='all'){
    //   $orders = order::where(['p_id'=>$request->get('id'),'active'=>'1'])->get();
    //     }else if($request->get('type')=='month'){
    //        $start = new DateTime();$start->modify('-6 month'); $start=$start->format('Y-m-d');
    //       $end = new DateTime();$end=$end->format('Y-m-d');
    //      $orders = order::where(['p_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$start." 00:00:00",$end." 23:59:59"])->get();
    //     }
    //     else{
    //       $orders = order::where(['p_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$request->get('start')." 00:00:00",$request->get('end')." 23:59:59"])->get();
    //     }
    //   return Response::json($orders);
    // }



    // public function distributer_details_load(Request $request){
    //   if($request->get('type')=='all'){
    //   $orders = order::where(['d_id'=>$request->get('id'),'active'=>'1'])->get();
    //     }else if($request->get('type')=='month'){
    //       $start = new DateTime();$start->modify('-6 month'); $start=$start->format('Y-m-d');
    //       $end = new DateTime();$end=$end->format('Y-m-d');
    //      $orders = order::where(['d_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$start." 00:00:00",$end." 23:59:59"])->get();
    //     }
    //     else{
    //       $orders = order::where(['d_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$request->get('start')." 00:00:00",$request->get('end')." 23:59:59"])->get();
    //     }
    //   return Response::json($orders);
    // }




    // public function lot_details_load(Request $request){
    //   if($request->get('type')=='all'){
    //   $orders = order::where(['lot_id'=>$request->get('id'),'active'=>'1'])->get();
    //     }else if($request->get('type')=='month'){
    //       $start = new DateTime();$start->modify('-6 month'); $start=$start->format('Y-m-d');
    //       $end = new DateTime();$end=$end->format('Y-m-d');
    //      $orders = order::where(['lot_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$start." 00:00:00",$end." 23:59:59"])->get();
    //     }
    //     else{
    //       $orders = order::where(['lot_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$request->get('start')." 00:00:00",$request->get('end')." 23:59:59"])->get();
    //     }
    //   return Response::json($orders);
    // }




    // public function export_balance_sheet(Request $request){

    //   if($request->get('type')=='all'){
    //   $data = order::where(['active'=>'1'])->get();
    //     }else if($request->get('type')=='month'){
    //       $start = new DateTime();$start->modify('-6 month'); $start=$start->format('Y-m-d');
    //       $end = new DateTime();$end=$end->format('Y-m-d');
    //      $data = order::where(['active'=>'1'])->whereBetween('created_at', [$start." 00:00:00",$end." 23:59:59"])->get();
    //     }
    //     else{
    //       $data = order::where(['active'=>'1'])->whereBetween('created_at', [$request->get('start')." 00:00:00",$request->get('end')." 23:59:59"])->get();
    //     }

    //   $data_array[] = array('S.No.','Order No.','Lot No.','Product name','Distributer','D. Contact','D. Email','Quantity','MRP','Discount','Extra Discount','Total Price','Method','Payment','Selling Time');
    //      $no=1; $mrp=0; $discount=0; $spl_discount=0; $price=0;$completed=0; $due=0;
    //   foreach($data as $dt){
    //    $data_array[] = array('S.No.' => $no++,'Order No.' => $dt->order_no,'Lot No.' => $dt->lot_no,'Product name' => $dt->p_name,'Distributer' => $dt->d_name,'D. Contact' => $dt->d_contact,'D. Email' => $dt->d_email,'Quantity' => $dt->total_unit,'MRP' => $dt->total_mrp,'Discount' => $dt->total_discount,'Extra Discount' => $dt->special_discount,'Total Price' => $dt->total_price,'Method' => $dt->payment_method,'Payment' => $dt->payment_status,'Selling Time' => $dt->selling_time);

    //    if($dt->payment_status=='Completed'){$completed=$completed+$dt->total_price;}
    //    else{$due=$due+$dt->total_price;}

    //    $mrp=$mrp+$dt->total_mrp;$discount=$discount+$dt->total_discount;$spl_discount=$spl_discount+$dt->special_discount;$price=$price+$dt->total_price;
    //   }
    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'','Discount'=>'','Extra Discount'=>'','Total Price'=>'','Method'=>'','Payment'=>'','Selling Time'=>'');

    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'Total MRP','Discount'=>'Discount','Extra Discount'=>'Extra Discount','Total Price'=>'Total Price','Method'=>'Completed Payment','Payment'=>'Due Payment','Selling Time'=>'');

    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'₹'.$mrp,'Discount'=>'₹'.$discount,'Extra Discount'=>'₹'.$spl_discount,'Total Price'=>'₹'.$price,'Method'=>'₹'.$completed,'Payment'=>'₹'.$due,'Selling Time'=>'');

    //   Excel::create('Balance Sheet', function($excel) use ($data_array){
    //     $excel->setTitle('Balance Sheet');
    //     $excel->sheet('Balance Sheet', function($sheet) use ($data_array){
    //       $sheet->fromArray($data_array, null, 'A1', false, false);
    //     });
    //   })->download('xlsx');
    // } 

    // public function export_product_details(Request $request){

    //   if($request->get('type')=='all'){
    //   $data = order::where(['p_id'=>$request->get('id'),'active'=>'1'])->get();
    //     }else if($request->get('type')=='month'){
    //       $start = new DateTime();$start->modify('-6 month'); $start=$start->format('Y-m-d');
    //       $end = new DateTime();$end=$end->format('Y-m-d');
    //      $data = order::where(['p_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$start." 00:00:00",$end." 23:59:59"])->get();
    //     }
    //     else{
    //       $data = order::where(['p_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$request->get('start')." 00:00:00",$request->get('end')." 23:59:59"])->get();
    //     }
        
    //   $data_array[] = array('S.No.','Order No.','Lot No.','Product name','Distributer','D. Contact','D. Email','Quantity','MRP','Discount','Extra Discount','Total Price','Method','Payment','Selling Time');
    //      $no=1; $mrp=0; $discount=0; $spl_discount=0; $price=0;$completed=0; $due=0;
    //   foreach($data as $dt){
    //    $data_array[] = array('S.No.' => $no++,'Order No.' => $dt->order_no,'Lot No.' => $dt->lot_no,'Product name' => $dt->p_name,'Distributer' => $dt->d_name,'D. Contact' => $dt->d_contact,'D. Email' => $dt->d_email,'Quantity' => $dt->total_unit,'MRP' => $dt->total_mrp,'Discount' => $dt->total_discount,'Extra Discount' => $dt->special_discount,'Total Price' => $dt->total_price,'Method' => $dt->payment_method,'Payment' => $dt->payment_status,'Selling Time' => $dt->selling_time);

    //    if($dt->payment_status=='Completed'){$completed=$completed+$dt->total_price;}
    //    else{$due=$due+$dt->total_price;}

    //    $mrp=$mrp+$dt->total_mrp;$discount=$discount+$dt->total_discount;$spl_discount=$spl_discount+$dt->special_discount;$price=$price+$dt->total_price;
    //   }
    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'','Discount'=>'','Extra Discount'=>'','Total Price'=>'','Method'=>'','Payment'=>'','Selling Time'=>'');

    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'Total MRP','Discount'=>'Discount','Extra Discount'=>'Extra Discount','Total Price'=>'Total Price','Method'=>'Completed Payment','Payment'=>'Due Payment','Selling Time'=>'');

    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'₹'.$mrp,'Discount'=>'₹'.$discount,'Extra Discount'=>'₹'.$spl_discount,'Total Price'=>'₹'.$price,'Method'=>'₹'.$completed,'Payment'=>'₹'.$due,'Selling Time'=>'');

    //   Excel::create('Product Balance Sheet', function($excel) use ($data_array){
    //     $excel->setTitle('Product Balance Sheet');
    //     $excel->sheet('Product Balance Sheet', function($sheet) use ($data_array){
    //       $sheet->fromArray($data_array, null, 'A1', false, false);
    //     });
    //   })->download('xlsx');
    // }







    // public function export_distributer_details(Request $request){

    //   if($request->get('type')=='all'){
    //   $data = order::where(['d_id'=>$request->get('id'),'active'=>'1'])->get();
    //     }else if($request->get('type')=='month'){
    //       $start = new DateTime();$start->modify('-6 month'); $start=$start->format('Y-m-d');
    //       $end = new DateTime();$end=$end->format('Y-m-d');
    //      $data = order::where(['d_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$start." 00:00:00",$end." 23:59:59"])->get();
    //     }
    //     else{
    //       $data = order::where(['d_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$request->get('start')." 00:00:00",$request->get('end')." 23:59:59"])->get();
    //     }
        
    //   $data_array[] = array('S.No.','Order No.','Lot No.','Product name','Distributer','D. Contact','D. Email','Quantity','MRP','Discount','Extra Discount','Total Price','Method','Payment','Selling Time');
    //      $no=1; $mrp=0; $discount=0; $spl_discount=0; $price=0;$completed=0; $due=0;
    //   foreach($data as $dt){
    //    $data_array[] = array('S.No.' => $no++,'Order No.' => $dt->order_no,'Lot No.' => $dt->lot_no,'Product name' => $dt->p_name,'Distributer' => $dt->d_name,'D. Contact' => $dt->d_contact,'D. Email' => $dt->d_email,'Quantity' => $dt->total_unit,'MRP' => $dt->total_mrp,'Discount' => $dt->total_discount,'Extra Discount' => $dt->special_discount,'Total Price' => $dt->total_price,'Method' => $dt->payment_method,'Payment' => $dt->payment_status,'Selling Time' => $dt->selling_time);

    //    if($dt->payment_status=='Completed'){$completed=$completed+$dt->total_price;}
    //    else{$due=$due+$dt->total_price;}

    //    $mrp=$mrp+$dt->total_mrp;$discount=$discount+$dt->total_discount;$spl_discount=$spl_discount+$dt->special_discount;$price=$price+$dt->total_price;
    //   }
    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'','Discount'=>'','Extra Discount'=>'','Total Price'=>'','Method'=>'','Payment'=>'','Selling Time'=>'');

    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'Total MRP','Discount'=>'Discount','Extra Discount'=>'Extra Discount','Total Price'=>'Total Price','Method'=>'Completed Payment','Payment'=>'Due Payment','Selling Time'=>'');

    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'₹'.$mrp,'Discount'=>'₹'.$discount,'Extra Discount'=>'₹'.$spl_discount,'Total Price'=>'₹'.$price,'Method'=>'₹'.$completed,'Payment'=>'₹'.$due,'Selling Time'=>'');

    //   Excel::create('Distributer Balance Sheet', function($excel) use ($data_array){
    //     $excel->setTitle('Distributer Balance Sheet');
    //     $excel->sheet('Distributer Balance Sheet', function($sheet) use ($data_array){
    //       $sheet->fromArray($data_array, null, 'A1', false, false);
    //     });
    //   })->download('xlsx');
    // }








    // public function export_lot_details(Request $request){

    //   if($request->get('type')=='all'){
    //   $data = order::where(['lot_id'=>$request->get('id'),'active'=>'1'])->get();
    //     }else if($request->get('type')=='month'){
    //       $start = new DateTime();$start->modify('-6 month'); $start=$start->format('Y-m-d');
    //       $end = new DateTime();$end=$end->format('Y-m-d');
    //      $data = order::where(['lot_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$start." 00:00:00",$end." 23:59:59"])->get();
    //     }
    //     else{
    //       $data = order::where(['lot_id'=>$request->get('id'),'active'=>'1'])->whereBetween('created_at', [$request->get('start')." 00:00:00",$request->get('end')." 23:59:59"])->get();
    //     }
        
    //   $data_array[] = array('S.No.','Order No.','Lot No.','Product name','Distributer','D. Contact','D. Email','Quantity','MRP','Discount','Extra Discount','Total Price','Method','Payment','Selling Time');
    //      $no=1; $mrp=0; $discount=0; $spl_discount=0; $price=0;$completed=0; $due=0;
    //   foreach($data as $dt){
    //    $data_array[] = array('S.No.' => $no++,'Order No.' => $dt->order_no,'Lot No.' => $dt->lot_no,'Product name' => $dt->p_name,'Distributer' => $dt->d_name,'D. Contact' => $dt->d_contact,'D. Email' => $dt->d_email,'Quantity' => $dt->total_unit,'MRP' => $dt->total_mrp,'Discount' => $dt->total_discount,'Extra Discount' => $dt->special_discount,'Total Price' => $dt->total_price,'Method' => $dt->payment_method,'Payment' => $dt->payment_status,'Selling Time' => $dt->selling_time);

    //    if($dt->payment_status=='Completed'){$completed=$completed+$dt->total_price;}
    //    else{$due=$due+$dt->total_price;}

    //    $mrp=$mrp+$dt->total_mrp;$discount=$discount+$dt->total_discount;$spl_discount=$spl_discount+$dt->special_discount;$price=$price+$dt->total_price;
    //   }
    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'','Discount'=>'','Extra Discount'=>'','Total Price'=>'','Method'=>'','Payment'=>'','Selling Time'=>'');

    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'Total MRP','Discount'=>'Discount','Extra Discount'=>'Extra Discount','Total Price'=>'Total Price','Method'=>'Completed Payment','Payment'=>'Due Payment','Selling Time'=>'');

    //   $data_array[] = array('S.No.'=>'','Order No.'=>'','Lot No.'=>'','Product name'=>'','Distributer'=>'','D. Contact'=>'','D. Email'=>'','Quantity'=>'','MRP'=>'₹'.$mrp,'Discount'=>'₹'.$discount,'Extra Discount'=>'₹'.$spl_discount,'Total Price'=>'₹'.$price,'Method'=>'₹'.$completed,'Payment'=>'₹'.$due,'Selling Time'=>'');

    //   Excel::create('Lot Balance Sheet', function($excel) use ($data_array){
    //     $excel->setTitle('Lot Balance Sheet');
    //     $excel->sheet('Lot Balance Sheet', function($sheet) use ($data_array){
    //       $sheet->fromArray($data_array, null, 'A1', false, false);
    //     });
    //   })->download('xlsx');
    // } 











}


