<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
	<head>
	<title>Sign Up</title>
		<link href="<? echo base_url(); ?>assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link href="<? echo base_url(); ?>assets/css/signup.css" rel="stylesheet">		
	</head>
	<body>	
		<div class="login-page">
			<div class="login-main">
				<div class="login-top">
					<img class="logo" src="<? echo base_url(); ?>assets/images/logo.jpg"  alt="Logo" /><h3>Sign up to Pride Admin</h3>
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
					<div class="user-password">
						<div class="input-group">
							<span class="input-group-addon"><label class="glyphicon glyphicon-lock"></label></span>
							<input type="password" placeholder="Reenter Password" id="repassword" required="">
						</div>
					</div>
					<div class="login-bottom">
						<div class="forgot">
							<a href="/user/">Back to Login Page</a>
						</div>
						<input id="btn-submit" type="button" value="Submit">
						<!---  Logo --->
						
						<!-------------->
						<div class="clearfix"> </div>
					</div>
				</div>
			</div>
		</div>
		<script src="<? echo base_url(); ?>assets/js/signup.js"></script>
	</body>
</html>


                      
						
