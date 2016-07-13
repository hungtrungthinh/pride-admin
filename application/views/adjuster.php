<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
	<head>
		<style>
			html, body {
				width: 99.8%;
				height: 98%;
				overflow: hidden;
			}
			img.form_photo {
				position: relative;
				border-radius: 50%;
				width: 220px;
				height: 220px;
				border: 1px solid #cecece;
			}
		</style>
	</head>
	<body style="overflow:hidden; height:100%;">
		<div id="toolbar" style="margin-left: 12px;height:40px;"></div>
		<div id="gridbox" style="width:99.2%;height:92.4%;background-color:white;"></div>
		<iframe name="upload_area" frameBorder="0" height="0"></iframe>
		<script src="<? echo base_url(); ?>assets/js/adjuster.js"></script>
	</body>
</html>
