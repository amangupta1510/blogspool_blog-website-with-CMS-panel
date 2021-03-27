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
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Mail\SendMaildmca;
use App\Mail\SendMailCareers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\admin;
use App\article;
use App\author;
use App\category;
use App\comment;
use App\contact;
use App\image_file;
use App\tag;
use DB;
use Carbon\Carbon;
use DateTime;


class homecontroller extends Controller
{   
	
    public function index(Request $request)
    { 
        if($request->has('search')and$request->get('search')!=''){
            $m_search = $request->get('search');
            $m_find = article::where('tags','like', '%'.$m_search.'%')
            ->orwhere('title','like', '%'.$m_search.'%')
            ->orwhere('description','like', '%'.$m_search.'%')
            ->orwhere('author_name','like', '%'.$m_search.'%')
            ->orwhere('category_name','like', '%'.$m_search.'%');
            $articles = $m_find->where(['active'=>'1'])->orderBy('id','desc')->paginate(10);
            $categories = category::where(['active'=>'1'])->orderBy('id','DESC')->get(); 
            $most_visited = article::where(['active'=>'1'])->orderBy('clicks','DESC')->paginate(5);
       
            return view('index',compact('articles','categories','most_visited'));
        }
        else{
            $articles = article::where(['active'=>'1'])->orderBy('id', 'DESC')->paginate(10);
            $categories = category::where(['active'=>'1'])->orderBy('id','DESC')->get(); 
            $most_visited = article::where(['active'=>'1'])->orderBy('clicks','DESC')->paginate(5);
       
            return view('index',compact('articles','categories','most_visited'));
        }
    }

     public function contact()
    {  
        $categories = category::where(['active'=>'1'])->orderBy('id','DESC')->get(); 
        $most_visited = article::where(['active'=>'1'])->orderBy('clicks','DESC')->paginate(5);
        
        return view('contact',compact('categories','most_visited'));
    }

     public function detail_blog(Request $request)
    {
        $article = article::find($request->get('blog'));
        $article->clicks=$article->clicks+1;
        $article->save();
        $article = article::where(['active'=>'1','id'=>$request->get('blog')])->get();
        $categories = category::where(['active'=>'1'])->orderBy('id','DESC')->get(); 
        $most_visited = article::where(['active'=>'1'])->orderBy('clicks','DESC')->paginate(5);
        $tags = explode (",", $article[0]->tags);  
        $query = article::where(['active'=>'1','id'=>'0']);

        foreach($tags as $tag){    
        $query->orWhere('tags','like','%'.$tag.'%');
     }
        $result = $query->orderBy('clicks','DESC')->paginate(3);
        $related_articles = $result; 
        return view('detail_blog',compact('article','categories','most_visited','related_articles'));
    }

    public function category (Request $request)
    {  
        $new_category = category::where(['active'=>'1','id'=>$request->get('category_id')])->get();
        $articles = article::where(['active'=>'1','category_id'=>$new_category[0]['id']])->orderBy('id', 'DESC')->paginate(10);
        $categories = category::where(['active'=>'1'])->orderBy('id','DESC')->get(); 
        $most_visited = article::where(['active'=>'1'])->orderBy('clicks','DESC')->paginate(5);
        return view('category',compact('new_category','articles','categories','most_visited'));
    }

     public function about()
    {  
       $categories = category::where(['active'=>'1'])->orderBy('id','DESC')->get(); 
       $most_visited = article::where(['active'=>'1'])->orderBy('clicks','DESC')->paginate(5);
        return view('about',compact('categories','most_visited'));
    }
    
    public function archive(Request $request)
    {
        
        $post = article::whereYear('created_at', '=', $request->year)
              ->whereMonth('created_at', '=', $request->month)
              ->get();
        $categories = category::where(['active'=>'1'])->orderBy('id','DESC')->get(); 
        $most_visited = article::where(['active'=>'1'])->orderBy('clicks','DESC')->paginate(5);
        return view('archive',compact('categories','most_visited','post'));
    }


















    
    public function enquiry(Request $request)
    {  
        $data =  array('name' => $request->name,'subject' => $request->subject,'email' => $request->email,'body' => $request->body);
        Mail::to($request->email)->send(new SendMail($data));
        return redirect()->route('thank_you');
    }
    public function dmca_submit(Request $request)
    {  
        $data =  array('name' => $request->name,'subject' => $request->subject,'email' => $request->email,'body' => $request->body);
        Mail::to($request->email)->send(new SendMaildmca($data));
        return redirect()->route('thank_you');
    }
    public function career_enquiry(Request $request)
    {  
        $data =  array('first_name' => $request->first_name,'last_name' => $request->last_name,'contact' => $request->contact,'email' => $request->email,'link' => $request->link,'interest' => $request->interest,'location' => $request->location);
        Mail::to($request->email)->send(new SendMailCareers($data));
        return redirect()->route('thank_you');
    }
}

