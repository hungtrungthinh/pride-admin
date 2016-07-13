<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
	<head>
		<title>Pride Admin</title>
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
		<!-- Bootstrap Core CSS -->
		<link href="<? echo base_url(); ?>assets/libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="<? echo base_url(); ?>assets/css/common.css" rel="stylesheet">
	</head>
	<body>
		<div class="page-container">
			<div class="left-content">
				<div class="inner-content">
					<!-- header-starts -->
					<div class="header-section">
					<!-- top_bg -->
						<div class="top_bg">							
							<div class="header_top">
								<div class="top_left">
									<h2><img src="/assets/images/logo.png" alt="" />Admin Panel</h2>
								</div>
								<div class="top_right">
									<ul>
										<li><i class="lnr lnr-clock"></i><span id="cur-time">10:53 pm 30-04-2016</span></li>
										<li><a href="/user/logout"><i class="fa fa-power-off"></i>Logout</a></li>
									</ul>
								</div>
								<div class="clearfix"> </div>
							</div>							
						</div>
						<div class="clearfix"></div>
						<!-- /top_bg -->
					</div>
					<div class="header_bg">							
						<div class="header">
							<div class="head-t">
								<div class="logo">
									<h4 id="menu-name"><i class="lnr lnr-layers"></i>Messages<h4>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
					<!-- //header-ends -->
					<iframe src="<?php echo $page; ?>" onload="this.height = $(document).height() - 187.9;" name="main-content" class="main-content" scrolling="no"></iframe>
				</div>
				<p class="copyright">© 2016. All Rights Reserved by <a href="">Pride</a></p>
			</div><!--//content-inner-->
				
			<div class="sidebar-menu"><!--/sidebar-menu-->
				<header class="logo1">
					<a href="#" class="sidebar-icon"> <span class="fa fa-bars" style="color:#fff"></span> </a> 
				</header>
				<div style="border-top:1px ridge rgba(255, 255, 255, 0.15)"></div>
				<div class="menu">
					<ul id="menu" >
						<li id="menu-messages"><a href="#"><i class="lnr lnr-layers"></i><span>Messages</span></a></li>
						<li id="menu-adjusters" ><a href="#"><i class="lnr lnr-users"></i><span>Adjusters</span></a></li>
						<li id="menu-claims" ><a href="#"><i class="lnr lnr-store"></i><span>Claim Type</span></a></li>
						<li id="menu-users" ><a href="#"><i class="lnr lnr-cog"></i><span>Users</span></a></li>
						<li id="menu-logout"><a href="#"><i class="lnr lnr-power-switch"></i><span>Logout</span></a></li>
					</ul>
				</div>
			</div>
			<div class="clearfix"></div>		
		</div>
		<script>
			var toggle = true;
						
			$(".sidebar-icon").click(function() {                
				if (toggle) {
					$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
					$("#menu span").css({"position":"absolute"});
				} else {
				$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
					setTimeout(function() {
					  $("#menu span").css({"position":"relative"});
					}, 400);
				}						
				toggle = !toggle;
			});
			
			$( window ).resize(function() {
				$(".main-content").css({
					height: $(document).height() - 187.9
				});
			});
			
			$("#menu-messages").click(
				function(){
					$("#menu-name").html("<i class='lnr lnr-layers'></i>Messages");
					window.open("/message", "main-content");
				}
			);
			$("#menu-adjusters").click(
				function(){
					$("#menu-name").html("<i class='lnr lnr-users'></i>Adjusters");
					window.open("/adjuster", "main-content");
				}
			);
			$("#menu-claims").click(
				function(){ 
					$("#menu-name").html("<i class='lnr lnr-store'></i>Claim Type");
					window.open("/claim", "main-content"); 
				}
			);
			$("#menu-users").click(
				function(){
					$("#menu-name").html("<i class='lnr lnr-cog'></i>Users");
					window.open("/user/users", "main-content"); 
				}
			);
			$("#menu-logout").click(
				function(){ 
					window.open("/user/logout", "_self");
				}
			);
			setInterval(function() {
				var curTime = new Date();
				$("#cur-time").html(curTime.getHours()  + ":" + curTime.getMinutes() + (curTime.getHours() > 12 ? " pm " : " am ") + ((curTime.getDate() < 9) ? ("0" + curTime.getDate()) : (curTime.getDate())) + "-" + ((curTime.getMonth() < 9) ? "0": "") + (curTime.getMonth() + 1) + "-" + curTime.getFullYear());
			}, 1000);
		</script>
		<script src="<? echo base_url(); ?>assets/libs/jquery/jquery.nicescroll.js"></script>
		<script src="<? echo base_url(); ?>assets/libs/jquery/scripts.js"></script>
		<script src="<? echo base_url(); ?>assets/libs/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>