@extends('main');

@section('title')
{{$article[0]->page_title}}
@endsection


@section('page')

@foreach($article as $ar) 
<article id="post-201" class="post-201 post type-post">

    <div class="detail-wrap">
        <header class="entry-header">
            <span class="cat-links"><a  rel="category tag">{{$ar->category_name}}</a></span><h1 class="entry-title">{{$ar->title}}</h1>
                <div class="author-date">
                                            <span class="author vcard"><a class="url fn n" >Admin</a></span>
                    
                                            <span class="separator"> / </span>
                    
                                            <span class="posted-on">{{date_format(date_create($ar->created_at),"jS M, Y")}}</span>
                                    </div><!-- .author-date -->
            
        </header><!-- .entry-header -->

                    <div class="entry-img">
                <img width="1280" height="720"  class="attachment-full size-full wp-post-image" alt="" loading="lazy" srcset="{{$ar->image}}" sizes="(max-width: 1280px) 100vw, 1280px" />         </div>
           
        <div class="entry-content  content_description" data-data="{{$ar->content}}"> 
            

    </div>

</article><!-- #post-## -->

@endforeach


<div class="related-posts" style="padding: 20px">
                        
                        <header class="page-header">
                            <h2 class="page-title">Related Posts</h2>       </header><!-- .page-header -->
                                @foreach($related_articles as $ra)
                                @if($ra->id != $ar->id && $ra->active == 1)
                                <div class="container" style="display: inline-block;">
                                <div onclick="location.href='{{ route('detail_blog',['blog'=>$ra->id]) }}';" style="cursor: pointer; width: 27rem; margin: 10 ; display: inline-block;" class="card " >
                                          <img width="330" height="300" class="attachment-full size-full wp-post-image md card-img-top" alt="" loading="lazy" srcset="{{$ra->image}}" sizes="(max-width: 1280px) 100vw, 1280px"/>
                                          <div class="card-body">
                                          <h5 class="card-title">{{$ra->title}}</h5>
                                            <p class="card-text">{{$ra->description}}</p>
                                          </div>
                                        </div>
                                        </div>
                                        @endif
                                        @endforeach
                                                        
                            

        </div>





@endsection









  
