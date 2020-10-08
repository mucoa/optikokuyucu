<aside class="main-sidebar sidebar-dark-green elevation-4">
	<!-- Brand Logo -->
	<a href="<?= base_url();?>" class="brand-link bg-success">
		<img src="<?= base_url("assets");?>/dist/img/logo.jpg"
			 alt="Kocaeli Üniversitesi Logo"
			 class="brand-image img-circle elevation-3"
			 style="opacity: .8">
		<span class="brand-text font-weight-light">Kocaeli Üniversitesi</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?=base_url("assets");?>/userImages/<?=$profile->resim?>" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="<?=base_url("profile")?>" class="d-block"><?=$profile->unvan." ".$profile->ad." ".$profile->soyad?></a>
			</div>
		</div>

		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<!-- Add icons to the links using the .nav-icon class
					 with font-awesome or any other icon font library -->
				<?php if (isAdmin()) {?>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-user-friends"></i>
						<p>
							Kullanıcılar
							<i class="fas fa-angle-left right"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?=base_url("dashboard/admins")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Yöneticiler</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url("dashboard/users")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Öğretim Üyeleri</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-book"></i>
						<p>
							Dersler
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?=base_url("dashboard/aders")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Açılan Dersleri Listele</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url("dashboard/ders")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Tüm Dersleri Listele</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url("dashboard/new_ders")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Yeni Ders Ekle</p>
							</a>
						</li>

					</ul>
				</li>

				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-pen"></i>
						<p>
							Bölümler
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?=base_url("dashboard/bolumler")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Bölümleri Listele</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url("dashboard/new_bolum")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Yeni Bölüm Ekle</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-university"></i>
						<p>
							Fakülteler
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?=base_url("dashboard/fakulte")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Fakülteleri Listele</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url("dashboard/new_fakulte")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Yeni Fakülte Ekle</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-calendar"></i>
						<p>
							Dönemler
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?=base_url("dashboard/donem")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Dönemleri Listele</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url("dashboard/new_donem")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Yeni Dönem Ekle</p>
							</a>
						</li>
					</ul>
				</li>
				<?php }?>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-clipboard-check"></i>
						<p>
							Notlar
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?=base_url("dashboard/notlar")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Notları Listele</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?=base_url("dashboard/test")?>" class="nav-link">
								<i class="far fa-circle nav-icon"></i>
								<p>Test Giriş</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="<?=base_url("dashboard/user_ders")?>" class="nav-link">
						<i class="nav-icon fas fa-align-center"></i>
						<p>
							Derslerim
						</p>
					</a>
				</li>

			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>
