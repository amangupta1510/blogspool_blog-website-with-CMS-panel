@extends('layout/vendor_dashboard')
@section('page')
<div id="content" class="pmd-content content-area dashboard" style="padding-bottom: 5px">
    <div class="container-fluid full-width-container">
        <h1></h1>
            
        <ol class="breadcrumb text-left">
          <li><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
          <li class="active">Edit Profile</li>
        </ol>
    
        <div class="section"> 

            <form method="post" action="{{ route('admin-edit_profile_submit') }}">
                @csrf
            <div class="pmd-card pmd-z-depth">
                <div class="pmd-card-body">

                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="lead">EDIT PROFILE</div>
                           
                        </div>
                    </div>

                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="username" class="control-label">
                                    Username
                                </label>
                                <input type="text" name="username" id="username" class="form-control" value="{{Auth::user()->username}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="name" class="control-label">
                                  Name
                                </label>
                                <input type="text" name="name" id="name" class="form-control" value="{{Auth::user()->name}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="contact" class="control-label">
                                    Contact
                                </label>
                                <input type="text" name="contact" id="contact" class="form-control" value="{{Auth::user()->contact}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="email" class="control-label">
                                    Email
                                </label>
                                <input type="email" name="email" id="email" class="form-control" value="{{Auth::user()->email}}" required>
                            </div>
                        </div>
                    </div>

 <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="address" class="control-label">
                                    Address
                                </label>
                                <input type="text" name="address" id="address" class="form-control" value="{{Auth::user()->address}}" required>
                            </div>
                        </div>
                    </div>
                   
                </div>

                <div class="pmd-card-actions">
                    <p align="right">
                    <button type="submit" class="btn pmd-ripple-effect btn-danger" name="btnEdit">Update</button>
                    </p>
                </div>
            </div>
            </form>
        </div>
            
    </div>

</div>
</div>

@endsection