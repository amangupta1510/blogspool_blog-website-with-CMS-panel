@extends('layout/vendor_dashboard')
@section('page')
@foreach($data as $dt)
<!--content area start-->
<div id="content" class="pmd-content content-area dashboard">

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

			<form action="{{ route('admin-edit_author_submit') }}" method="post" enctype="multipart/form-data">
				@csrf
				 <input type="hidden" name="id" value="{{app('request')->input('id')}}">
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-body">

					<div class="group-fields clearfix row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="lead">EDIT AUTHOR</div>
						</div>
					</div>

					<div class="group-fields clearfix row">

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="username" class="control-label">Username</label>
								<input type="text" name="username" id="username" class="form-control" value="{{$dt->username}}" placeholder="" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="password" class="control-label">Password</label>
								<input type="text" name="password" id="password" class="form-control" value="******" placeholder="" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="name" class="control-label">Name</label>
								<input type="text" name="name" id="name" class="form-control" value="{{$dt->name}}" placeholder="" required>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="mobile" class="control-label">Mobile Number</label>
								<input type="number" name="mobile" id="mobile" class="form-control" value="{{$dt->mobile}}" placeholder="" required>
							</div>
						</div>


						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="email" class="control-label">Email</label>
								<input type="text" name="email" id="email" class="form-control" value="{{$dt->email}}" placeholder="" required>
							</div>
						</div>


						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="address" class="control-label">Address</label>
								<input type="text" name="address" id="address" class="form-control" value="{{$dt->address}}" placeholder="" >
							</div>
						</div>	

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="form-group pmd-textfield">
								<label for="description" class="control-label">Description</label>
								<input type="text" name="description" id="description" class="form-control" value="{{$dt->description}}" placeholder="" >
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

</div>
@endforeach
@endsection
