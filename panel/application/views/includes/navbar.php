<nav class="main-header navbar navbar-expand navbar-dark navbar-dark">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?php echo base_url("dashboard/index");?>" class="nav-link">Anasayfa</a>
		</li>
	</ul>

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<!-- setttings Dropdown Menu -->
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="fas fa-cog"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="<?=base_url("profile")?>" class="dropdown-item">
					<i class="fas fa-user-circle mr-2"></i> Profil
				</a>
				<div class="dropdown-divider"></div>
				<a href="<?=base_url("logout")?>" class="dropdown-item">
					<i class="fas fa-power-off mr-2"></i> Çıkış
				</a>
			</div>
		</li>
	</ul>
</nav>
