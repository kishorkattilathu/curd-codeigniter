<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<head>
<title>Visitors an Admin Panel Category Bootstrap Responsive Website Template | Login :: w3layouts</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="<?php echo base_url('assets/css/style.css')?>" rel='stylesheet' type='text/css' />
<link href="<?php echo base_url('assets/css/style-responsive.css')?>" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="<?php echo base_url('assets/css/font.css')?>" type="text/css"/>
<link href="<?php echo base_url('assets/css/font-awesome.css')?>" rel="stylesheet"> 
<!-- //font-awesome icons -->
<script src="<?php echo base_url('assets/js/jquery2.0.3.min.js')?>"></script>
<script>
	var base_url = "<?php echo base_url('') ?>"
</script>
</head>
<body>
<div class="log-w3">
<div class="w3layouts-main">
	<h2>Sign In Now</h2>
		<form action="#" id="login_form" method="post">
			<div>
			<input type="email" class="ggg" name="email" id="email" placeholder="E-MAIL" required="">
			<span class="tex-danger" id="error-email"></span>
			</div>
			<div>
			<input type="password" class="ggg" name="password" id="password" placeholder="PASSWORD" required="">
			<span class="tex-danger" id="error-email"></span>
			</div>
			<h6><a href="#">Forgot Password?</a></h6>
				<div class="clearfix"></div>
				<input type="button" value="Sign In" id="login_button" name="login_button">
		</form>
		<p>Don't Have an Account ?<a href="<?php echo base_url('User/register')?>">Create an account</a></p>
</div>
</div>
<script src="<?php echo base_url('assets/js/bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dcjqaccordion.2.7.js')?>"></script>
<script src="<?php echo base_url('assets/js/scripts.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.slimscroll.js')?>"></script>
<script src="<?php echo base_url('assets/js/jquery.nicescroll.js')?>"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="<?php echo base_url('assets/js/jquery.scrollTo.js')?>"></script>
</body>
</html>


<script>
	$(document).ready(function(){
		console.log('login ready');
		$('#login_button').on('click',function(){
			login();
		});
	});

	function validate(){
		var Valid = true;
		if($('#email').val().trim() == ''){
			alert('please insert email');
			Valid = false;
		}

		if($('#password').val() == ''){
			alert('please insert password');
			Valid = false;
		}
		return Valid;
	}

	function login(){
		var input_array = ['email','password'];
		remove_error(input_array);
		if(validate()){
			console.log('validate');
			var formData = $('#login_form').serialize();

			$.ajax({
				data : formData,
				url : base_url + 'User/login',
				type : 'POST',
				dataType : 'JSON',
				success : function(response){
					if(response.status){
						window.location.href = response.redirect_url;
					}else{
						alert(response.message);
					}
				},
				error : function(xhr,error,status){
					console.log('xhr',xhr);
					console.log('error',error);
					console.log('status',status);
				}
			});
		}else{
			console.log('not validate');

		}
	}

		function remove_error(input_array){
			$.each(input_array,function(key,input_id){
				$('#error-' + input_id).html('');

			});
		}

		function display_error(response_error){
			$.each(response_error,function(input_id,error_message){
				$('#error-'+input_id).html(error_message);
			});
		}
</script>
