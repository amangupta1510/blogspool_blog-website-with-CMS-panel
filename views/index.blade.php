@extends('main');

@section('title')
Blogspool - Something you should know
@endsection


@section('page')

@foreach($articles as $ar)

<article id="" class=" post  ">
			<div class="entry-img">
			<a href="{{ route('detail_blog',['blog'=>$ar->id]) }}"><img width="345" height="225" src="{{$ar->image}}" class="attachment-blog-way-common size-blog-way-common wp-post-image" alt="" loading="lazy" /></a>
       </div>
       	<div class="detail-wrap">
		<header class="entry-header">
			<span class="cat-links"><a  rel="category tag">{{$ar->category_name}}</a></span><h2 class="entry-title"><a href="" rel="bookmark">{{$ar->title}}</a></h2>
				<div class="author-date">
											<span class="author vcard"><a class="url fn n" >admin</a></span>
					
											<span class="separator"> / </span>
					
											<span class="posted-on">{{date_format(date_create($ar->created_at),"jS M, Y")}}</span>
									</div><!-- .author-date -->

					</header><!-- .entry-header -->

		<div class="entry-content">
			<p>{{$ar->description}}</p>
<p><a href="{{ route('detail_blog',['blog'=>$ar->id]) }}" class="btn-continue">Continue Reading<span class="arrow-continue">&rarr;</span></a></p>
		</div><!-- .entry-content -->
	</div>

</article><!-- #post-## -->



@endforeach

<p>{{$articles->links()}}</p> 

@endsection









  
