<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Kullanıcı Ekle</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Anasayfa</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url("dashboard/users");?>">Kullanıcılar</a></li>
						<li class="breadcrumb-item active">Kullanıcı Ekle</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<form action="<?php echo base_url("dashboard/user_add");?>" enctype="multipart/form-data" method="post">
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Kişisel Bilgiler</h3>

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
								<label for="ad">Ad:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("userFN"); ?></small>
								<?php } ?>
								<input type="text" class="form-control" name="userFN"  value="<?php echo isset($form_error) ? set_value("userFN") : ""?>">
							</div>
							<!-- /.form-group -->
							<div class="form-group">
								<label>Telefon:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("userPhone"); ?></small>
								<?php } ?>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-phone"></i></span>
									</div>
									<input type="text" class="form-control"  name="userPhone" data-inputmask='"mask": "(999) 999-9999"' data-mask placeholder="(999) 999-99-99"  value="<?php echo isset($form_error) ? set_value("userPhone") : ""?>">
								</div>
								<!-- /.input group -->
							</div>
							<!-- /.form-group -->
						</div>
						<!-- /.col -->
						<div class="col-md-6">
							<div class="form-group">
								<label for="ad">Soyad:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("userLN"); ?></small>
								<?php } ?>
								<input type="text" class="form-control" name="userLN"  value="<?php echo isset($form_error) ? set_value("userLN") : ""?>">
							</div>
							<!-- /.form-group -->
							<div class="form-group">
								<label for="ad">Email:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("userMail"); ?></small>
								<?php } ?>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-envelope"></i></span>
									</div>
									<input type="text" class="form-control"  name="userMail"  value="<?php echo isset($form_error) ? set_value("userMail") : ""?>">
								</div>
							</div>

							<!-- /.form-group -->
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="ad">Unvan:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("userUN"); ?></small>
								<?php } ?>
								<input type="text" class="form-control" name="userUN"  value="<?php echo isset($form_error) ? set_value("userUN") : ""?>">
							</div>
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
					</div>
					<!-- /.row -->
				</div>
				<!-- /.card-body -->
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Genel Bilgiler</h3>

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
								<label for="ad">Kullanıcı Adı:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("userName"); ?></small>
								<?php } ?>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-user"></i></span>
									</div>
									<input type="text" class="form-control"  name="userName"  value="<?php echo isset($form_error) ? set_value("userName") : ""?>">
								</div>
							</div>
							<!-- /.form-group -->
							<div class="form-group">
								<label>Sicil No:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("userSicil"); ?></small>
								<?php } ?>
								<input type="text" class="form-control" name="userSicil"  value="<?php echo isset($form_error) ? set_value("userSicil") : ""?>">
								<!-- /.input group -->
							</div>
							<!-- /.form-group -->
							<div class="form-group">
								<label for="ad">Fakülte No:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("userF"); ?></small>
								<?php } ?>
								<input type="text" class="form-control" name="userF"  value="<?php echo isset($form_error) ? set_value("userF") : ""?>">
							</div>
						</div>
						<!-- /.col -->
						<div class="col-md-6">
							<div class="form-group">
								<label for="ad">Şifre:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("userPass"); ?></small>
								<?php } ?>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-unlock"></i></span>
									</div>
									<input type="password" class="form-control"  name="userPass"  value="<?php echo isset($form_error) ? set_value("userPass") : ""?>">
								</div>
							</div>
							<!-- /.form-group -->
							<div class="form-group">
								<label for="ad">Bolum No:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("userB"); ?></small>
								<?php } ?>
								<input type="text" class="form-control" name="userB" value="<?php echo isset($form_error) ? set_value("userB") : ""?>">
							</div>

							<div class="form-group">
								<label for="ad">Yetki:</label>
								<?php if(isset($form_error)) { ?>
									<small class="input-form-error"><?php echo form_error("userClass"); ?></small>
								<?php } ?>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text"><i class="fas fa-key"></i></span>
									</div>
									<select name="userClass" class="form-control">
										<option value=""<?php echo isset($form_error) ? option_result(set_value("userClass"), "") : ""?>>-----</option>
										<option value="admin"<?php echo isset($form_error) ? option_result(set_value("userClass"), "admin") : ""?>>Admin</option>
										<option value="user" <?php echo isset($form_error) ? option_result(set_value("userClass"), "user") : ""?>>Kullanıcı</option>
									</select>
								</div>
							</div>
							<!-- /.form-group -->
						</div>
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</div>
				<!-- /.row -->
			</div>
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Resim&Durum</h3>

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
								<label for="exampleInputFile">Dosya seçiniz:</label>
								<?php if(isset($pic_error) && $pic_error == true) { ?>
									<small class="input-form-error"><?php echo "Lütfen resminizin türünü ve boyutunu kontrol edin 2MB üstündeki resimler kabul edilmemektedir!"; ?></small>
								<?php } ?>
								<div class="input-group">
									<div class="custom-file">
										<input type="file" name="userFile" class="custom-file-input" id="exampleInputFile">
										<label class="custom-file-label" for="exampleInputFile">.jpg, .jpeg, .png türleri kabul edilmektedir!</label>
									</div>
									<div class="input-group-append">
										<span class="input-group-text" id="">Yükle</span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Durum:</label>
								<div class="switch ml-4">
									<label style="font-weight: lighter">OFF<input type="checkbox" name="userStat" value="A" <?php echo isset($form_error) ? set_value("userStat")=="A" ? "checked" : "" : ""; ?>><span class="lever"></span>ON</label><small class="ml-3">(Durum kullanıcının sistemde aktif yada pasif olmasını sağlar.Pasif haldeki kullanıcı sisteme giriş yapamayacaktır!)</small>
								</div>

							</div>
						</div>
					</div>
					<!-- /.row -->
				</div>
				<!-- /.row -->
			</div>
				<div class="card-footer">
					<div class="float-right">
						<a href="<?php echo base_url();?>"><button type="button" class="btn bg-gradient-secondary">Geri</button></a>
						<button type="submit" class="btn bg-gradient-teal"><i class="fas fa-user-plus"></i> Ekle</button>
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

