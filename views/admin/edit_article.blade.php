@extends('layout/vendor_dashboard')
@section('page')
@foreach($data as $dt)
<!--content area start-->
<div id="content" class="pmd-content content-area dashboard">
	<script src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
	
	<!--tab start-->
	<div class="container-fluid full-width-container">
		<h1></h1>
			
		<!--breadcrum start-->
		<ol class="breadcrumb text-left">
		  <li><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
		  <li class="active">Edit Author</li>
		</ol>
		<!--breadcrum end-->
	
		<div class="section"> 

			<form action="{{ route('admin-edit_article_submit') }}" method="post" enctype="multipart/form-data">
				@csrf
				 <input type="hidden" name="id" value="{{app('request')->input('id')}}">
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-body">

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="lead">EDIT ARTICLE</div>
						</div>
					</div>

					<div class="group-fields clearfix row">

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="title" class="control-label">Title</label>
								<input type="text" name="title" id="title" class="form-control"  value="{{$dt->title}}" placeholder="" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="page_title" class="control-label">Page Title</label>
								<input type="text" name="page_title" id="page_title" class="form-control" value="{{$dt->page_title}}" placeholder="" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="meta_tag" class="control-label">Meta Keywords</label>
								<input type="text" name="meta_tag" id="meta_tag" class="form-control" value="{{$dt->meta_tag}}" placeholder="" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="meta_description" class="control-label">Meta Description</label>
								<input type="text" name="meta_description" id="meta_description" class="form-control"
								 value="{{$dt->meta_description}}" placeholder="" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="description" class="control-label">Description</label>
								<input type="text" name="description" id="description" class="form-control" value="{{$dt->description}}" placeholder="" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">       
								<label>Select Category</label>
								<input type="hidden" name="category_name" id="category_name" value="{{$dt->category_name}}"  >
								<select class="select-with-search form-control pmd-select2" name="category_id" id="category_id" required>
									@foreach($categories as $c)
									<option value="{{$c->id}}" data-name="{{$c->category_name}}" @if($dt->category_id==$c->id) selected="" @endif>{{$c->category_name}}</option>
									@endforeach
								</select>
							</div>
						</div>



						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="tags" class="control-label">Tags</label>
								<input type="text" name="tags" id="tags" class="form-control" value="{{$dt->tags}}" placeholder="" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="image" class="control-label">Image</label>
								<input type="file" name="image" id="image" class="dropify-image" data-max-file-size="1M" data-allowed-file-extensions="jpg jpeg png gif" />
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield">
							<textarea class="form-control" value=""  id="full_content" name="full_content"></textarea>
                  			<script>                             
                  			CKEDITOR.replace('full_content');
                			</script>
							</div>
						</div>						


						<div class="pmd-card-actions col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<p align="right">
							<button type="submit" class="btn pmd-ripple-effect btn-danger" name="submit">Submit</button>
							</p>
						</div>					

						</div>

				</div>

			</div> <!-- section content end -->  
			</form>
		</div>
			
	</div><!-- tab end -->
	<div class="content_main hidden" data-data="{{$dt->content}}"></div>

</div>
@endforeach
@endsection
@section('js')
<script type="text/javascript">	
    	CKEDITOR.instances['full_content'].setData($('.content_main').data('data'));
	$('.article_form').on('submit', function(event){
  event.preventDefault();
  $('#category_name').val($("select#category_id option").filter(":selected").data('name'));
   for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }
   var loading = document.getElementById('loading');
    loading.style.display='';
  $.ajax({
   url:"{{ route('admin-add_article_submit') }}",
   method:"POST",
   data:new FormData(this),
   dataType:'JSON',
   contentType: false,
   cache: false,
   processData: false,
   success:function(data)
   {
        if ((data.errors)) {
          if (!$('.add-success').hasClass('hidden')) {
          $('.add-success').addClass('hidden');
        }  
          $('.add-error').removeClass('hidden');
          $('.add-error').text('Please Fill All The Fields');
           $("#loading").fadeOut(500);
        
        }else{
          $('.article_form').trigger("reset");
          CKEDITOR.instances['full_content'].setData('');
          if (!$('.add-error').hasClass('hidden')) {
          $('.add-error').addClass('hidden'); }
          if ($('.add-success').hasClass('hidden')) {
          $('.add-success').removeClass('hidden');
           $('.add-success').text('Added Successfully...');
           $("#loading").fadeOut(500); }

  $("#loading").fadeOut(500);
  }

    },
    })
    });

</script>

@endsection 
