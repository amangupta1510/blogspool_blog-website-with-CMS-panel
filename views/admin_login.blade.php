<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@yield('title')
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('css/util.css')}}" rel="stylesheet" />
    <link href="{{asset('css/main.css')}}" rel="stylesheet" />
    <link href="{{asset('fonts/icon-font.min.css')}}" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
</head>
<body oncontextmenu="return false">
   <div id="notice" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
<h5 id="noti1"></h5>
         </div>
  <div class="modal-footer">
            <button class="btn btn-warning" type="button" data-dismiss="modal">
              <span class="glyphicon glyphicon-remobe"></span>Close
            </button>
          </div>
      </div>
    </div>
  </div>
</div></div> 
    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{ asset('wp-content/image/beer-background.jpg') }}');">
            <div  class="wrap-login100 p-t-15 p-l-8">
                 <img src="{{ asset('admin_css/images/logo.png') }}" width="95%">
                <span class="login100-form-title p-b-0 p-t-30" style="font-family: Ubuntu-Bold;color: rgba(10, 10, 10, 0.8);">
                    Admin Login
                </span>
                 @if($errors->any())
<div class="alert alert-danger" style="padding-top: -25px;">
          <li>Incorrect Username or Password...</li>
</div>
@endif        
                <form autocomplete="off" method="POST" action="{{ route('admin-login') }}" class="login100-form validate-form p-b-33 p-t-5">
                        @csrf
                    <div class="wrap-input100 validate-input" data-validate = "Enter username">
                        <input class="input100" type="text" name="username" value="{{ old('username') }}" placeholder="User name" autocomplete="false" required>
                        <span class="focus-input100" data-placeholder="&#xe82a;" ></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password"  placeholder="Password" name="password" autocomplete="false" required>
                        <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-32">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>

                </form>
            </div>

        </div>

            <div class="col-md-12" style="min-height: 5vh; max-height: 5vh;padding-top: 6px;background-color: rgba(43, 43, 51, 0.9);">
                      <p style=" color: #fff" class="text-center">© 2020 Figurati20 | Designed by <a style=" color: #fff">Delta Trek</a> </p>
                    </div>  
    </div>
<script src="{{ asset('js/jquery.min.js') }}"> </script>
<script src="{{ asset('js/bootstrap.min.js') }}"> </script>
 
     
</body>
</html>