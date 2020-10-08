<!DOCTYPE html>
<html>
<head>
	<?php $this->load->view("includes/head");?>
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<!-- Navbar -->
	<?php $this->load->view("includes/navbar");?>
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	<?php $this->load->view("includes/asidebar");?>

	<!-- Content Wrapper. Contains page content -->
	<?php $this->load->view("dashboard_v/{$subViewFolder}");?>
	<!-- /.content-wrapper -->

	<?php $this->load->view("includes/footer");?>

	<!-- Control Sidebar -->
	<aside class="control-sidebar control-sidebar-dark">
		<!-- Control sidebar content goes here -->
	</aside>
	<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<?php $this->load->view("includes/script");?>
</body>
</html>
