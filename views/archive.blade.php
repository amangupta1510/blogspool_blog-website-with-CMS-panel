@extends('main');

@section('title')
Archives
@endsection

@section('page')
	
		<header class="page-header">
		
			<h1 class="page-title">Archives <span></span></h1>		</header><!-- .page-header -->


			@foreach($post as $ar)

<article id="post-201" class="post-201 post type-post status-publish format-standard has-post-thumbnail sticky hentry category-games tag-dynamo tag-gamers tag-games tag-games-vlogs tag-mortal tag-pro tag-pro-player tag-pubg tag-pubg-in-india tag-pubg-india tag-pubg-indian-version tag-pubg-mobile tag-pubg-mobile-india tag-pubg-unban tag-pubg-unban-in-india tag-scout tag-unban">
			<div class="entry-img">
			<a href="{{ route('index') }}"><img width="345" height="225" src="{{$ar->image}}" class="attachment-blog-way-common size-blog-way-common wp-post-image" alt="" loading="lazy" /></a>
       </div>
       	<div class="detail-wrap">
		<header class="entry-header">
			<span class="cat-links"><a href="{{ route('index') }}" rel="category tag">{{$ar->category_name}}</a></span><h2 class="entry-title"><a href="pubg-mobile-india/index.html" rel="bookmark">{{$ar->title}}</a></h2>
				<div class="author-date">
											<span class="author vcard"><a class="url fn n" href="author/admin/index.html">admin</a></span>
					
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

@endsection
	