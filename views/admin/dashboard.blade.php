@extends('layout/vendor_dashboard')
@section('page')
<style>
  .borderless tr, .borderless td, .borderless th {
    border: none !important;
   }
</style>
<!--content area start-->
<div id="content" class="pmd-content content-area dashboard">

	<!--tab start-->
	<div class="container-fluid full-width-container">
	
		<!-- Title -->
		<h1 class="section-title" id="services">
		</h1><!-- End Title -->
			
		<!--breadcrum start-->
		<ol class="breadcrumb text-left">
		  <li class="active">Dashboard</li>
		</ol><!--breadcrum end-->
	
		<div class="section"> 

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			


		 </div> <!--end Today's Site Activity -->

		 <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-title" align="center">
					<h1 class="pmd-card-title-text typo-fill-secondary propeller-title">INFO</h1>
				</div>
				<div class="pmd-card-body">
					<table class="table pmd-table" id="table-propeller">
						<tr>
							<td>Category</td>
							<td>:</td>
							<td>--</td>
						</tr>
						<tr>
							<td>Product</td>
							<td>:</td>
							<td>--</td>
						</tr>
						<tr>
							<td>Notification Template</td>
							<td>:</td>
							<td>--</td>
						</tr>
						<tr>
							<td>Help Menu</td>
							<td>:</td>
							<td>--</td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-title" align="center">
					<h1 class="pmd-card-title-text typo-fill-secondary propeller-title">SETTING</h1>
				</div>
				<div class="pmd-card-body" align="center">
					<table class="table pmd-table" id="table-propeller">
						<tr>
							<td>Currency</td>
							<td>:</td>
							<td>--</td>
						</tr>
						<tr>
							<td>Tax</td>
							<td>:</td>
							<td>-- %</td>
						</tr>
						<tr>
							<td>Notification</td>
							<td>:</td>

							<td>Not Configured</td>
						</tr>
						<tr>
							<td>Administrator</td>
							<td>:</td>
							<td><a href="{{ route('admin-profile') }}">Edit</a></td>
						</tr>
					</table>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
			<div class="pmd-card pmd-z-depth">
				<div class="pmd-card-title" align="center">
					<h1 class="pmd-card-title-text typo-fill-secondary propeller-title">ABOUT</h1>
				</div>
				<div class="pmd-card-body" align="center">
					<p>Admin Panel to Manage BlogsPool Website.</p>
					<br><br><br><br>
					<p>support@deltatrek.in</p>
				</div>
			</div>
		</div>

		</div>
			
	</div>

</div>
@endsection