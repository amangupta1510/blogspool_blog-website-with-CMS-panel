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
use App\accounting;
use App\pincode;
use App\category;
use App\address;
use App\bill;
use App\cart;
use App\current_order;
use App\order;
use App\product;
use App\offer;
use App\transaction;
use App\wallet;
use App\user;
use App\guest;
use App\delivery_boy;
use App\vendor;
use App\admin;
use App\config;
use App\currency;
use App\fcm_template;
use App\fcm_token;
use App\help;
use App\setting;
use App\shipping;
use App\unit_type;
use App\wishlist;
use App\worker;
use DB;
use Geographical;
use Image;


class usercontroller extends Controller
{ 
  /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:user');
    }

     public function home(Request $request)
    {   if($request->has('latitude')&&$request->has('longitude')){
          if(Auth::check()){
                  $file = user::find(Auth::user()->id);
                  $file->latitude = $request->get('latitude');
                  $file->longitude = $request->get('longitude');
                  $file->save();
                  $lat=$request->get('latitude');
                  $lng=$request->get('longitude');
     $vendor = vendor::selectRaw('*, ( 6367 * acos( cos( radians( ? ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( latitude ) ) ) ) AS distance', [$lat, $lng, $lat])
    ->having('distance', '<', 50)
    ->where('active', '1')
    ->orderBy('distance')
    ->get();
            return view('user.front_page',compact('lat','lng','vendor'));
           }
           else{
          $exist=0;
          $exist= guest::where(['ip'=>request()->ip(),'active'=>1])->count();
                  if($exist==0){
                  $file = new guest();
                  $file->ip = request()->ip();
                  $file->latitude = $request->get('latitude');
                  $file->longitude = $request->get('longitude');
                  $file->active=1;
                  $file->save();
     $vendor = vendor::selectRaw('*, ( 6367 * acos( cos( radians( ? ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( latitude ) ) ) ) AS distance', [$lat, $lng, $lat])
    ->having('distance', '<', 50)
     ->where('active', '1')
    ->orderBy('distance')
    ->get();
                  return view('user.front_page',compact('lat','lng','vendor'));
                }
                else{
                  $file = guest::where(['ip'=>request()->ip(),'active'=>1])->update(['latitude' => $request->get('latitude'),'longitude' => $request->get('longitude')]);
                  $lat=$request->get('latitude');
                  $lng=$request->get('longitude');
     $vendor = vendor::selectRaw('*, ( 6367 * acos( cos( radians( ? ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( latitude ) ) ) ) AS distance', [$lat, $lng, $lat])
    ->having('distance', '<', 50)
     ->where('active', '1')
    ->orderBy('distance')
    ->get();
            return view('user.front_page',compact('lat','lng','vendor'));
                }
                }
              }
              else{
                $lat=0;
                $lng=0;
          $vendor = vendor::where('active','X')->select('id','vendor_name','vendor_address','vendor_range','photo','longitude','latitude')->get();
            return view('user.front_page',compact('lat','lng','vendor'));
              
              }
        
    }



    function home_search(Request $request){
          if($request->has('s')&&$request->get('s')!=''){
           $search = $request->get('s');
           $product = product::selectRaw('*, ( 6367 * acos( cos( radians( ? ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( latitude ) ) ) ) AS distance',[Auth::user()->latitude, Auth::user()->longitude, Auth::user()->latitude])
    ->having('distance', '<', 50)
    ->where('product_name', 'like', '%'.$search.'%')
    ->orWhere('product_category', 'like', '%'.$search.'%')
    ->orderBy('distance')
    ->get();
     $vendor = vendor::selectRaw('*, ( 6367 * acos( cos( radians( ? ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ? ) ) + sin( radians( ? ) ) * sin( radians( latitude ) ) ) ) AS distance', [Auth::user()->latitude, Auth::user()->longitude, Auth::user()->latitude])
    ->having('distance', '<', 50)
    ->where('vendor_name', 'like', '%'.$search.'%')
     ->orWhere('vendor_address', 'like', '%'.$search.'%')
    ->orderBy('distance')
    ->get();
      return view('user.search_result',compact('product','vendor'));
        }else{
          $product = product::where('active','X')->select('product_name','product_category','product_image')->get();
          $vendor = vendor::where('active','X')->select('id','vendor_name','vendor_address','vendor_range','photo','longitude','latitude')->get();
        return view('user.search_result',compact('product','vendor'));
  }
      }




    public function vendor(Request $request)
    {   $products = product::where(['vendor_id'=>$request->get('id'),'active'=>'1'])->orderBy('product_name', 'DESC')->get();
     $category = category::where(['vendor_id'=>$request->get('id'),'active'=>'1'])->orderBy('category_name', 'DESC')->get();
      $vendor = vendor::where(['id'=>$request->get('id'),'active'=>'1'])->get();
        return view('user.vendor_store',compact('products','category','vendor'));
    }

     public function product(Request $request)
    {   $products = product::where(['vendor_id'=>$request->get('id'),'active'=>'1'])->orderBy('product_name', 'DESC')->get();
     $category = category::where(['vendor_id'=>$request->get('id'),'active'=>'1'])->orderBy('category_name', 'DESC')->get();
      $vendor = vendor::where(['id'=>$request->get('id'),'active'=>'1'])->get();

   
        return view('user.vendor_store',compact('products','category','vendor'));
    }


    public function checkout(Request $request)
    {
          if($request->get('ip')=="true"){
     $crt= cart::where(['ip'=>request()->ip(),'active'=>1])->update(['user_id' =>Auth::user()->id,'user_name' => Auth::user()->name]);
      $cart_number = 0;
  foreach ($crt as $cart) {
   $cart_number = $cart_number + $cart->product_quantity;
  }
      $pr = user::find(Auth::user()->id);
     $pr->cart = $cart_number;
     $pr->save();
  }
       $address = address::where(['user_id'=>Auth::user()->id,'active'=>'1'])->orderBy('id', 'DESC')->get();
       $address_number = address::where(['user_id'=>Auth::user()->id,'active'=>'1'])->count();
      return view('user.checkout',compact('address','address_number'));
    }



    public function new_address(Request $request)
    {
      return view('user.location');
    }
    public function new_address_submit(Request $request)
    {
        

        $file = new address();
                  $file->user_id = Auth::user()->id;
                  $file->user_name =Auth::user()->name;
                  $file->name = $request->name;
                  $file->mobile = $request->mobile;
                  $file->pincode = $request->address_pincode;
                  $file->address = $request->address;
                  $file->address_type = $request->address_type;
                  $file->landmark = $request->landmark;
                  $file->gps_address = $request->address_address;
                  $file->longitude = $request->address_longitude;
                  $file->latitude = $request->address_latitude;
                  $file->active=1;
                  $file->save();
                  if($request->old_range!=''&&$request->old_latitude!=''&&$request->old_longitude!=''){
                    $img = '/user/checkout?range='.$request->old_range.'&latitude='.$request->old_latitude.'&longitude='.$request->old_longitude;
                   return redirect($img); 
                  }
      return redirect('/user/checkout');
    }
    
    public function place_order(Request $request)
    {
 
       $carts = cart::where(['user_id'=>Auth::user()->id,'active'=>'1'])->orderBy('id', 'DESC')->get();
        $cart_number = 0;
  foreach ($carts as $cart) {
   $cart_number = $cart_number + $cart->quantity;
  }
    
     $addresses = address::where(['id'=>$request->address_id,'active'=>'1'])->orderBy('id', 'DESC')->get();
$order_id = 'FRD-'.'1X'.mt_rand(100000,999999);
 $amount=0;$tax=0;$shipping=0;$total=0;
 foreach($carts as $cart){
  $amount=$amount+$cart->amount;
         $tax=($amount*0)/100;
         if($amount>=100){
          $shipping=0;
         }
         else{
         $shipping=15;  
         }
         $total=$amount+$tax+$shipping;
  }
  foreach ($addresses as $add) {
   $address = $add->address;
   $gps = $add->gps_address;
   $lati = $add->latitude;
   $longi = $add->longitude;
   $mobile = $add->mobile;
   $id = $add->id;
  }
                 foreach($carts as $pr){
                  $file = new current_order();
                  $file->order_no = $order_id;
                  $file->vendor_id = $pr->vendor_id;
                  $file->vendor_name =$pr->vendor_name;
                  $file->product_id = $pr->product_id;
                  $file->product_name =$pr->product_name;
                  $file->product_category=$pr->product_category;
                  $file->product_quantity=$pr->product_quantity;
                  $file->product_unit=$pr->product_unit;
                  $file->product_unit_type=$pr->product_unit_type;
                  $file->product_image=$pr->product_image;
                  $file->product_mrp=$pr->product_mrp;
                  $file->product_price=$pr->product_price;
                  $file->latitude=$lati;
                  $file->longitude=$longi;
                  $file->gps=$gps;
                  $file->product_unit=$pr->product_unit;
                  $file->user_id =Auth::user()->id;
                  $file->user_name=Auth::user()->name;
                  $file->amount=$pr->amount;
                  $file->order_status='Accepted';
                  $file->tax=$tax;
                  $file->pdf=base_path().'/public_html/bill_pdf/'.$order_id.'.pdf';
                  $file->delivery_charge=$shipping;
                  $file->delivery_address_id = $id;
                  $file->delivery_address = $address;
                  $file->delivery_mobile = $mobile;
                  $file->active=1;
                  $file->save();

                   $file = new order();
                  $file->order_no = $order_id;
                  $file->vendor_id = $pr->vendor_id;
                  $file->vendor_name =$pr->vendor_name;
                  $file->product_id = $pr->product_id;
                  $file->product_name =$pr->product_name;
                  $file->product_category=$pr->product_category;
                  $file->product_quantity=$pr->product_quantity;
                  $file->product_unit=$pr->product_unit;
                  $file->product_unit_type=$pr->product_unit_type;
                  $file->product_image=$pr->product_image;
                  $file->product_mrp=$pr->product_mrp;
                  $file->product_price=$pr->product_price;
                  $file->latitude=$lati;
                  $file->longitude=$longi;
                  $file->gps=$gps;
                  $file->product_unit=$pr->product_unit;
                  $file->user_id =Auth::user()->id;
                  $file->user_name=Auth::user()->name;
                  $file->amount=$pr->amount;
                  $file->order_status='Accepted';
                  $file->tax=$tax;
                  $file->pdf=base_path().'/public_html/bill_pdf/'.$order_id.'.pdf';
                  $file->delivery_charge=$shipping;
                  $file->delivery_address_id = $id;
                  $file->delivery_address = $address;
                  $file->delivery_mobile = $mobile;
                  $file->active=1;
                  $file->save();

                 
}
    $pdf = \App::make('dompdf.wrapper');
     set_time_limit(600); 
     $pdf->loadview('user.bill_pdf',compact('order_id','carts'));
     $output = $pdf->output();
    file_put_contents('bill_pdf/'.$order_id.'.pdf', $output);
    $carts = cart::where(['user_id'=>Auth::user()->id,'active'=>'1'])->update(['active'=>'2']);
      $pr = user::find(Auth::user()->id);
     $pr->cart = 0;
     $pr->save();
    return redirect('/user/orders');
     
    }
     



     public function orders(Request $request)
    {
       $orders = order::where(['user_id'=>Auth::user()->id,'active'=>'1'])->orderBy('id', 'DESC')->get();
       $order_number = order::where(['user_id'=>Auth::user()->id,'active'=>'1'])->count();
      
      return view('user.orders',compact('orders','order_number'));
    }
 public function orders_reload(Request $request)
    {
       $orders = order::where(['user_id'=>Auth::user()->id,'active'=>'1'])->orderBy('id', 'DESC')->get();
       $order_number = order::where(['user_id'=>Auth::user()->id,'active'=>'1'])->count();
      
      return view('user.orders_reload',compact('orders','order_number'));
    }



      

 public function cart(Request $request)
    {
       $carts = cart::where(['user_id'=>Auth::user()->id,'active'=>'1'])->orderBy('id', 'DESC')->get();
        $products = product::where(['id'=>'ff','active'=>'1'])->orderBy('id', 'DESC')->get();
        foreach ($carts as $cart) {
  $products = product::where(['id'=>$cart->product_id,'active'=>'1'])->orderBy('id', 'DESC')->get();
  }
        return view('user.cart',compact('carts','products'));
    }







 public function product_add_cart(Request $request)
    {   $products = product::where(['id'=>$request->id,'active'=>'1'])->get();
    $pr_in_cart ='';
     $pr_in_cart_c=0;
      $pr_in_cart = cart::where(['product_id'=>$request->id,'user_id'=>Auth::user()->id,'active'=>'1'])->orderBy('id', 'DESC')->get();
      $pr_in_cart_c = cart::where(['product_id'=>$request->id,'user_id'=>Auth::user()->id,'active'=>'1'])->count();
         foreach ($products as $pr) {
          foreach ($pr_in_cart as $p) {
            if($p->vendor_id!=$pr->vendor_id)
            {
    $pr_cart = cart::find($p->id);
    $pr_cart->active='2';
    $pr_cart->save();
     $pr = user::find(Auth::user()->id);
     $pr->cart = $pr->cart - $pr_cart->product_quantity;
     $pr->save();
            }
          }
            if($pr_in_cart_c>0){
   foreach ($pr_in_cart as $prd) { 
    $unit= $prd->product_quantity+1;
    $amount= $prd->amount + $pr->product_price;
    $pr_cart = cart::find($prd->id);
    $pr_cart->product_quantity = $unit;
    $pr_cart->amount=$amount;
    $pr_cart->save();
     $pr = user::find(Auth::user()->id);
     $pr->cart = $pr->cart+1;
     $pr->save();
    return Response::json($pr_cart);
}
}
        
                 else{
                  $file = new cart();
                  $file->vendor_id = $pr->vendor_id;
                  $file->vendor_name =$pr->vendor_name;
                  $file->user_id = Auth::user()->id;
                  $file->user_name =Auth::user()->name;
                  $file->product_id = $pr->id;
                  $file->product_name =$pr->product_name;
                  $file->product_category=$pr->product_category;
                  $file->product_unit=$pr->product_unit;
                  $file->product_unit_type=$pr->product_unit_type;
                  $file->product_quantity=1;
                  $file->product_image=$pr->product_image;
                  $file->product_mrp=$pr->product_mrp;
                  $file->product_price=$pr->product_price;
                  $file->product_off=$pr->product_off;
                  $file->product_status=$pr->product_status;
                  $file->amount=$pr->product_price;
                  $file->product_off=$pr->product_off;
                  $file->active=1;
                  $file->save();
                   $pr = user::find(Auth::user()->id);
                   $pr->cart = $pr->cart+1;
                   $pr->save();
                  return Response::json($file);
              }
         
       }
     }
        


     public function product_increase_cart(Request $request)
 {
    $pr_cart = cart::find($request->id);
    $pr_cart->product_quantity=$request->quantity;
    $pr_cart->amount=$request->quantity*$request->price;
    $pr_cart->save();
    $pr = user::find(Auth::user()->id);
    $pr->cart = $pr->cart+1;
    $pr->save();
    return Response::json($pr_cart);

}
 public function product_decrease_cart(Request $request)
 {
    $pr_cart = cart::find($request->id);
    $pr_cart->product_quantity=$request->quantity;
    $pr_cart->amount=$request->quantity*$request->price;
    $pr_cart->save();
    $pr = user::find(Auth::user()->id);
    $pr->cart = $pr->cart-1;
    $pr->save();
    return Response::json($pr_cart);

}
 
 public function product_delete_cart(Request $request)
{
     $pr_cart = cart::find($request->id);
     $pr_cart->active='0';
    $pr_cart->save();
     $pr = user::find(Auth::user()->id);
     $pr->cart = $pr->cart - $pr_cart->product_quantity;
     $pr->save();
    return Response::json($pr_cart);

}
 

  public function reload_cart(Request $request)
    {
         $carts = cart::where(['user_id'=>Auth::user()->id,'active'=>'1'])->orderBy('id', 'DESC')->get();
         $products = product::where(['id'=>'ff','active'=>'1'])->orderBy('id', 'DESC')->get();
        foreach ($carts as $cart) {
  $products = product::where(['id'=>$cart->product_id,'active'=>'1'])->orderBy('id', 'DESC')->get();
  }
        return view('user.cart_reload',compact('carts','products'));
    }

 public function support(Request $request)
    {$carts = cart::where(['user_id'=>Auth::user()->id,'active'=>'1'])->orderBy('id', 'DESC')->get();
       $cart_number = 0;
  foreach ($carts as $cart) {
   $cart_number = $cart_number + $cart->unit;
  }
      return view('user.support',compact('cart_number','carts'));
    }

public function settings(Request $request)
    {$carts = cart::where(['user_id'=>Auth::user()->id,'active'=>'1'])->orderBy('id', 'DESC')->get();
       $cart_number = 0;
  foreach ($carts as $cart) {
   $cart_number = $cart_number + $cart->unit;
  }
      return view('user.support',compact('cart_number','carts'));
    }


public function changepassword(Request $request){

        $old = Auth::user()->password;
if(Hash::check($request->old,$old)){ 
    $inv = user::where('id',Auth::user()->id)->update(['password'=> Hash::make($request->new)]);
    return Response::json($inv);
}
else{
    return Response::json ( array ( 'errors' => 'fail') );
}

}
public function rating(Request $request){
    

    $pr_cart = order::find($request->id);
    if ($pr_cart->rating==NULL) {
       $pr =  product::find($request->pr_id);
    $prv =  vendor::find($pr->vendor_id);
    $rate = $request->rating/$prv->total_rate;
    $prv->total_rate = $prv->total_rate+1;
    $prv->rating = $prv->rating+$rate;
    $prv->save();
    }
    else{
     $pr =  product::find($request->pr_id);
    $prv =  vendor::find($pr->vendor_id);
    $rate_old = $pr_cart->rating/($prv->total_rate-1);
    $rate = $request->rating/($prv->total_rate-1);
    $prv->total_rate = $prv->total_rate;
    $prv->rating = $prv->rating-$rate_old+$rate;
    $prv->save(); 
    }
    $pr_cart->rating=$request->rating;
    $pr_cart->save();

   
    return Response::json($pr_cart);

}

  public function open_order(Request $request)
    {
       $orders = order::where(['order_no'=>$request->id,'active'=>'1'])->orderBy('id', 'DESC')->get();
       $i=1;
       foreach ($orders as $order) {
        if($i==1){
         $address = address::where('id',$order->delivery_address_id)->get();
         $i++;
        }
       }
      return view('user.open_order',compact('orders','address'));
    }










   }
   //$string ="SELECT id,vendor_name,vendor_address,vendor_range,total_rate,rating,(6371*acos(cos(radians(?))*cos(radians(latitude))*cos(radians(longitude)-radians(?))+sin(radians(?))*sin(radians(latitude)))) As distance From vendors HAVING distance<? ORDER BY distance Limit 0,20;";
//$args =[$request->get('latitude'),$request->get('longitude'),$request->get('latitude'),5];
//$data=DB::select($string,$args);
//return ($data)?$data:null;





