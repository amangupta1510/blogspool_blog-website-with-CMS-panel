@extends('layout/vendor_dashboard')
@section('page')
<div id="content" class="pmd-content content-area dashboard">
    <div class="container-fluid full-width-container">
        <h1></h1>
            
        <ol class="breadcrumb text-left">
          <li><a href="{{ route('admin-dashboard') }}">Dashboard</a></li>
          <li class="active">Update Password</li>
        </ol>
    
        <div class="section"> 

            <form  method="post" action="{{ route('admin-change_password_submit') }}">
            <div class="pmd-card pmd-z-depth">
                <div class="pmd-card-body">
                @csrf
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="lead">UPDATE PASSWORD</div>
                           
                        </div>
                    </div>


              
                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="password" class="control-label">
                                    OLD Password
                                </label>
                                <input type="password" name="oldpassword" id="oldpassword" class="form-control" required>
                            </div>
                        </div>
                    </div>
  <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="password" class="control-label">
                                   New Password
                                </label>
                                <input type="password" name="password2" id="password2" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="group-fields clearfix row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                <label for="repassword" class="control-label">
                                    Re Password
                                </label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="pmd-card-actions">
                    <p align="right">
                    <button type="submit" class="btn pmd-ripple-effect btn-danger" disabled="true" id="signupattemt" name="btnEdit">Update</button>
                    </p>
                </div>
            </div>
            </form>
        </div>
            
    </div>

</div>
@endsection
@section('js')
<script type="text/javascript">

  $('#password').on('keyup', function() {
   var value2 = $("input[name='password2']").val();
   var value1 = $(this).val();
   if(value1!=value2){
     $('#password').attr('style','background:rgba(221,17,68,0.2);');
      $('#signupattemt').attr('disabled',true);
   }
   else{
    $('#password').attr('style','background:#fff;');
    $('#signupattemt').attr('disabled',false);
   }
  });
</script>
@endsection