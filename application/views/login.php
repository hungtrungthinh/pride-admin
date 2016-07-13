<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
	<head>
	<title>Log in</title>
		<link href="<? echo base_url(); ?>assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="<? echo base_url(); ?>assets/css/login.css" rel="stylesheet">
	</head>
	<body>	
		<div class="login-page">
			<div class="login-main">
				<div class="login-top">
					<img class="logo" src="<? echo base_url(); ?>assets/images/logo.jpg"  alt="Logo" /><h3>Sign in to Pride Admin</h3>
				</div>
				<div class="login-block">
					<div class="user-name">
						<div class="input-group">
							<span class="input-group-addon"><label class="glyphicon glyphicon-user"></span>
							<input type="text" placeholder="User Name" id="user_id" required="">
						</div>
					</div>
					<div class="user-password">
						<div class="input-group">
							<span class="input-group-addon"><label class="glyphicon glyphicon-lock"></label></span>
							<input type="password" placeholder="Password" id="password" required="">
						</div>
					</div>
					<div class="login-bottom">
						<input id="btn-login" type="button" value="Log in">
						<input id="btn-signup" type="button" value="Sign up">
						<div class="clearfix"> </div>
					</div>
				</div>
			</div>
		</div>
		<script src="<? echo base_url(); ?>assets/js/login.js"></script>
	</body>
</html>


                      
						
