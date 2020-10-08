<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Fakülte Ekle</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Anasayfa</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url("dashboard/fakulte");?>">Fakülteler</a></li>
						<li class="breadcrumb-item active">Fakülte Ekle</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

  <!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<form action="<?php echo base_url("dashboard/fakulte_add");?>" enctype="multipart/form-data" method="post">
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Fakülte Bilgileri</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
						<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
					</div>
				</div>
				<!-- /.card-header -->

				<div class="card-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="ad">Fakülte Adı:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("fakulteAdi"); ?></small>
								<?php } ?>
								<input type="text" class="form-control" name="fakulteAdi"  value="<?php echo isset($form_error) ? set_value("fakulteAdi") : ""?>">
							</div>
							<!-- /.form-group -->
							<div class="form-group">
								<label>Durum:</label>
								<div class="switch ml-4">
									<label style="font-weight: lighter">OFF<input type="checkbox" name="userStat" value="A" <?php echo isset($form_error) ? set_value("userStat")=="A" ? "checked" : "" : ""; ?>><span class="lever"></span>ON</label><small class="ml-3">(Durum kullanıcının sistemde aktif yada pasif olmasını sağlar.Pasif haldeki kullanıcı sisteme giriş yapamayacaktır!)</small>
								</div>
							</div>
							<!-- /.form-group -->
						</div>
						<!-- /.col -->
						<div class="col-md-6">
							<div class="form-group">
								<label for="ad">Fakülte Kodu:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("fakulteKodu"); ?></small>
								<?php } ?>
								<input type="text" class="form-control" name="fakulteKodu"  value="<?php echo isset($form_error) ? set_value("fakulteKodu") : ""?>">
							</div>
							<!-- /.form-group -->

						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
					</div>
					<!-- /.row -->
				</div>

			</div>
				<div class="card-footer">
					<div class="float-right">
						<a href="<?php echo base_url("dashboard/fakulte");?>"><button type="button" class="btn bg-gradient-secondary">Geri</button></a>
						<button type="submit" class="btn bg-gradient-teal"><i class="fas fa-plus-circle"></i> Ekle</button>
					</div>
				</div>
			</form>
			</div>
		</div>

		<!-- Default box -->
		<!-- /.card -->
	</section>
	<!-- /.content -->
</div>
