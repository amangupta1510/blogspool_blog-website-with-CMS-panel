@extends('layout/vendor_dashboard')
@section('page')
<!--content area start-->
<div id="content" class="pmd-content content-area dashboard">

	<!--tab start-->
	<div class="container-fluid full-width-container">
	
		<h1 class="section-title" id="services"></h1>
			
		<!--breadcrum start-->
		<ol class="breadcrumb text-left">
		  <li><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
		  <li class="active">Image List</li>
		</ol><!--breadcrum end-->
	
		<div class="section" id="tbody"> 
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-body">

					<div class="group-fields clearfix row">
						<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
							<div class="lead">Image List</div>
						</div>
					</div>

					<div class=""> 
								<?php $no=1;?>
							       @foreach($images as $c)
								
									<div class="card " style="width: 22rem; border:  solid #363636bd; margin: 5 ; display: inline-block;">
  									<img width="330" height="200" class="attachment-full size-full wp-post-image md card-img-top" alt="" loading="lazy" srcset="/{{$c->url}}" sizes="(max-width: 1280px) 100vw, 1280px"/>
  									<div class="card-body">
									
									<input type="text" value="{{$c->url}}" id="copy_{{ $c->id }}" class='copyfrom' tabindex='-1' aria-hidden='true'>
									<button onclick="copyToClipboard('copy_{{ $c->id }}')" class = "btn btn-primary" style="margin-left: 70; margin-bottom: 5">Copy link</button>
									
    								<a class="btn" href="{{ route('admin-delete_image',['id'=>$c->id]) }}" style="margin-left: 40;" onclick="return confirm('Are you sure want to Delete This Image ?')"><span style="font-size: 1.3em; color: #ff5c33;"><i class="fas fa-trash-alt"></i></span></a>
  									</div>
									</div>
								@endforeach
					</div>
					
				</div>
			</div> <!-- section content end -->  
			 <p>{{$images->links()}}</p>
		</div>
			
	</div><!-- tab end -->

</div><!--end content area-->



@endsection
