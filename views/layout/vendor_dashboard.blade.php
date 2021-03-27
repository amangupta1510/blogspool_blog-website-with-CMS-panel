
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Propeller Admin Dashboard">
<meta content="width=device-width, initial-scale=1, user-scalable=no" name="viewport">
<meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
     <meta http-equiv="Pragma-directive: no-cache">
     <meta http-equiv="Cache-directive: no-cache">

<title>BlogsPool</title>
<meta name="description" content="Admin is a material design and bootstrap based responsive dashboard template created mainly for admin and backend applications."/>

<link rel="shortcut icon" type="image/x-icon" href="{{asset('admin_css/images/favicon.png')}}">

<!-- Google icon -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Bootstrap css -->
<link rel="stylesheet" type="text/css" href="{{asset('admin_css/css/bootstrap.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin_css/css/preloader.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin_css/css/dropify.css')}}">
<link href="{{asset('admin_css/css/font-awesome.css')}}" rel="stylesheet">
<!-- Propeller css -->
<!-- build:[href] assets/css/ -->
<link rel="stylesheet" type="text/css" href="{{asset('admin_css/css/propeller.min.css')}}">
<!-- /build -->

<!-- Select2 css-->
<link rel="stylesheet" type="text/css" href="{{asset('admin_css/plugins/select2/css/select2.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('admin_css/plugins/select2/css/select2-bootstrap.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('admin_css/plugins/select2/css/pmd-select2.css')}}" />

<link rel="stylesheet" type="text/css" href="{{asset('admin_css/plugins/pagination/css/pagination.css')}}" />

<!-- Propeller date time picker css-->
<!-- <link rel="stylesheet" type="text/css" href="components/datetimepicker/css/bootstrap-datetimepicker.css" /> -->
<!-- <link rel="stylesheet" type="text/css" href="components/datetimepicker/css/pmd-datetimepicker.css" /> -->

<!-- Propeller theme css-->
<link rel="stylesheet" type="text/css" href="{{asset('admin_css/themes/css/propeller-theme.css')}}" />

<!-- Propeller admin theme css-->
<link rel="stylesheet" type="text/css" href="{{asset('admin_css/themes/css/propeller-admin.css')}}">
<script src="https://kit.fontawesome.com/99424e9e8e.js" crossorigin="anonymous"></script>
<style>
      html, body {
        max-height: 100%;
        margin: 0;
        padding: 0;
      }
    
body::-webkit-scrollbar {
  width: 13px;               /* width of the entire scrollbar */
}
body::-webkit-scrollbar-track {
  background: #e6bf55;        /* color of the tracking area */
}
body::-webkit-scrollbar-thumb {
  background-color: #27211d;    /* color of the scroll thumb */
  border-radius: 12px;       /* roundness of the scroll thumb */
  border: 2px solid #d4b04f;  /* creates padding around scroll thumb */
}
.md{
	margin: 8;
}
.copyfrom {
        position: absolute;
        left: -9999px;
    }
    </style>
</head>

<body onload="preloader()">
<div id="loading">
<div id="loading-center">
<div id="loading-center-absolute">
<div class="object" id="object_four"></div>
<div class="object" id="object_three"></div>
<div class="object" id="object_two"></div>
<div class="object" id="object_one"></div>
</div>
</div>
</div>
@yield('popup')
<div tabindex="-1" class="modal fade" id="notification" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header pmd-modal-bordered">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                                <h2 class="pmd-card-title-text">Add Shipping</h2>
                                            </div>
                                           <div id="notification_body"></div>
                                                <button data-dismiss="modal" class="btn pmd-ripple-effect btn-default" type="button">Cancel</button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
<!-- Header Starts -->
<!--Start Nav bar -->
<nav class="navbar navbar-inverse navbar-fixed-top pmd-navbar pmd-z-depth">

	<div class="container-fluid"  style="background-color: #e6bf55;">
		<div class="pmd-navbar-right-icon pull-right navigation">
		
		</div>
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<a href="javascript:void(0);" data-target="basicSidebar" data-placement="left" data-position="slidepush" is-open="true" is-open-width="1200" class="btn btn-sm pmd-btn-fab pmd-btn-flat pmd-ripple-effect pull-left margin-r8 pmd-sidebar-toggle"><i class="material-icons md-light">menu</i></a>	
		  <a href="{{ route('admin-dashboard') }}" class="navbar-brand">
		  <img src="{{ asset('admin_css/images/logo.png') }}" height="50px">
		  </a>
		</div>
	</div>

</nav><!--End Nav bar -->
<!-- Header Ends -->

<!-- Sidebar Starts -->
<div class="pmd-sidebar-overlay"></div>

<!-- Left sidebar -->
<aside id="basicSidebar" class="pmd-sidebar sidebar-default pmd-sidebar-slide-push pmd-sidebar-left pmd-sidebar-open bg-fill-darkblue sidebar-with-icons" role="navigation">
	<ul class="nav pmd-sidebar-nav">
		
		<!-- User info -->
		<li class="dropdown pmd-dropdown pmd-user-info visible-xs visible-md visible-sm visible-lg">
			<a aria-expanded="false" data-toggle="dropdown" class="btn-user dropdown-toggle media" data-sidebar="true" aria-expandedhref="javascript:void(0);">
				<div class="media-left">
					<img src="{{asset('admin_css/themes/images/user-icon.png')}}" alt="New User">
				</div>
				<div class="media-body media-middle">Hello, {{Auth::user()->name}}</div>
				<div class="media-right media-middle"><i class="dic-more-vert dic"></i></div>
			</a>
			<ul class="dropdown-menu">
				<li><a href="{{ route('admin-profile') }}">Profile</a></li>
				<li><a href="{{ route('admin-change_password') }}">Update Password</a></li>
				<li><a href="{{ route('admin-logout') }}" onclick="return confirm('Are you sure want to Logout?')">Logout</a></li>
			</ul>
		</li><!-- End user info -->
		
		<li> 
			<a class="pmd-ripple-effect" href="{{ route('admin-dashboard') }}">	
				<i class="media-left media-middle material-icons">dashboard</i>
				<span class="media-body">Dashboard</span>
			</a> 
		</li>

		<li class="dropdown pmd-dropdown"> 
			<a aria-expanded="false" data-toggle="dropdown" class="btn-user dropdown-toggle media" data-sidebar="true" href="javascript:void(0);">	
				<i class="material-icons media-left pmd-sm">local_mall</i> 
				<span class="media-body">Authors</span>
				<div class="media-right media-bottom"><i class="dic-more-vert dic"></i></div>
			</a> 
			<ul class="dropdown-menu">
				<li><a href="{{ route('admin-add_author') }}">Add New</a></li>
				<li><a href="{{ route('author_list') }}">Author List</a></li>
			</ul>
		</li>

		<li class="dropdown pmd-dropdown"> 
			<a aria-expanded="false" data-toggle="dropdown" class="btn-user dropdown-toggle media" data-sidebar="true" href="javascript:void(0);">	
				<i class="material-icons media-left pmd-sm">content_paste</i> 
				<span class="media-body">Categories</span>
				<div class="media-right media-bottom"><i class="dic-more-vert dic"></i></div>
			</a> 
			<ul class="dropdown-menu">
				<li><a href="{{ route('admin-add_category') }}">Add New</a></li>
				<li><a href="{{ route('category_list') }}">Category List</a></li>
			</ul>
		</li>

		<li class="dropdown pmd-dropdown"> 
			<a aria-expanded="false" data-toggle="dropdown" class="btn-user dropdown-toggle media" data-sidebar="true" href="javascript:void(0);">	
				<i class="material-icons media-left pmd-sm">dns</i> 
				<span class="media-body">Tags</span>
				<div class="media-right media-bottom"><i class="dic-more-vert dic"></i></div>
			</a> 
			<ul class="dropdown-menu">
				<li><a href="{{ route('admin-add_tag') }}">Add New</a></li>
				<li><a href="{{ route('tag_list') }}">Tag List</a></li>
			</ul>
		</li>

		<li class="dropdown pmd-dropdown"> 
			<a aria-expanded="false" data-toggle="dropdown" class="btn-user dropdown-toggle media" data-sidebar="true" href="javascript:void(0);">	
				<i class="media-left media-middle material-icons">map</i>
				<span class="media-body">Images</span>
				<div class="media-right media-bottom"><i class="dic-more-vert dic"></i></div>
			</a> 
			<ul class="dropdown-menu">
				<li><a href="{{ route('admin-add_image') }}">Add New</a></li>
				<li><a href="{{ route('image_list') }}">All Images</a></li>
			</ul>
		</li>
		
		<li class="dropdown pmd-dropdown"> 
			<a aria-expanded="false" data-toggle="dropdown" class="btn-user dropdown-toggle media" data-sidebar="true" href="javascript:void(0);">	
				<i class="material-icons media-left pmd-sm">content_paste</i>  
				<span class="media-body">Article</span>
				<div class="media-right media-bottom"><i class="dic-more-vert dic"></i></div>
			</a> 
			<ul class="dropdown-menu">
				<li><a href="{{ route('admin-add_article') }}">Add New</a></li>
				<li><a href="{{ route('article') }}">Article List</a></li>
			</ul>
		</li>

		<li> 
			<a class="pmd-ripple-effect" href="{{ route('admin-logout') }}" onclick="return confirm('Are you sure want to Logout?')">	
				<i class="media-left media-middle material-icons">power_settings_new</i>
				<span class="media-body">Logout</span>
			</a> 
		</li>
		
	</ul>
</aside><!-- End Left sidebar -->
<!-- Sidebar Ends --> 
@yield('page')
<!--footer start-->
<footer class="admin-footer" style="margin-top: 10px;">
 <div class="container-fluid">
 	<ul class="list-unstyled list-inline">
	 	<a href="https://deltatrek.in/">Copyright 2020 Delta Trek </a>
    </ul>
 </div>
</footer>
<!--footer end-->
<!-- Footer Ends -->

<!-- Scripts Starts -->
<script src="{{asset('admin_css/js/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('admin_css/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin_css/js/propeller.min.js')}}"></script>
<script src="{{asset('admin_css/js/dropify.js')}}"></script>
<script>
	$(document).ready(function() {
		var sPath=window.location.pathname;
		var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
		$(".pmd-sidebar-nav").each(function(){
			$(this).find("a[href='"+sPage+"']").parents(".dropdown").addClass("open");
			$(this).find("a[href='"+sPage+"']").parents(".dropdown").find('.dropdown-menu').css("display", "block");
			$(this).find("a[href='"+sPage+"']").parents(".dropdown").find('a.dropdown-toggle').addClass("active");
			$(this).find("a[href='"+sPage+"']").addClass("active");
		});
		$(".auto-update-year").html(new Date().getFullYear());
	});
</script> 
<!-- Select2 js-->
<script type="text/javascript" src="{{asset('admin_css/plugins/select2/js/select2.full.js')}}"></script>

<!-- Propeller Select2 -->
<script type="text/javascript">
	$(document).ready(function() {
		<!-- Simple Selectbox -->
		$(".select-simple").select2({
			theme: "bootstrap",
			minimumResultsForSearch: Infinity,
		});
		<!-- Selectbox with search -->
		$(".select-with-search").select2({
			theme: "bootstrap"
		});
		<!-- Select Multiple Tags -->
		$(".select-tags").select2({
			tags: false,
			theme: "bootstrap",
		});
		<!-- Select & Add Multiple Tags -->
		$(".select-add-tags").select2({
			tags: true,
			theme: "bootstrap",
		});
	});
</script>
<script type="text/javascript" src="{{asset('admin_css/plugins/select2/js/pmd-select2.js')}}"></script>
<script>
	$(document).ready(function() {
		var sPath=window.location.pathname;
		var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
		$(".pmd-sidebar-nav").each(function(){
			$(this).find("a[href='"+sPage+"']").parents(".dropdown").addClass("open");
			$(this).find("a[href='"+sPage+"']").parents(".dropdown").find('.dropdown-menu').css("display", "block");
			$(this).find("a[href='"+sPage+"']").parents(".dropdown").find('a.dropdown-toggle').addClass("active");
			$(this).find("a[href='"+sPage+"']").addClass("active");
		});
	});
</script>
<script type="text/javascript">
	var loading = document.getElementById('loading');
	function preloader(){
   loading.style.display='none';
	}
</script>
<!-- login page sections show hide -->
<script type="text/javascript">
	$(document).ready(function(){
	 $('.app-list-icon li a').addClass("active");
		$(".login-for").click(function(){
			$('.login-card').hide()
			$('.forgot-password-card').show();
		});
		$(".signin").click(function(){
			$('.login-card').show()   
			$('.forgot-password-card').hide();
		});
	});
</script>
<!-- Scripts Ends -->

									<script>
   										 function copyToClipboard(id) {
											document.getElementById(id).select();
  											document.execCommand("copy");
												
   											 }
									</script>


<script>
            $(document).ready(function(){
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });


                $('.dropify-video').dropify({
                    messages: {
                        default: '<center>Drag and drop a video here or click</center>'
                    }
                });

                $('.dropify-notification').dropify({
                    messages: {
                        default : '<center>Drag and drop a image here or click<br>(Optional)</center>',
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
</script>
@yield('js')
</body>
</html>