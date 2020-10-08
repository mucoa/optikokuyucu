<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<img src="<?=base_url("assets");?>/userImages/<?=$item_profile->resim;?>" class="img-circle" width="90" height="90" alt="<?=ucfirst($item_profile->ad)." ".ucfirst($item_profile->soyad);?>">
					<h1><?=ucfirst($item_profile->ad)." ".ucfirst($item_profile->soyad);?>,</h1>
						<p>Kişisini düzenliyorsunuz</p>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Anasayfa</a></li><?php $tip=$item->class=="admin" ? "admins" : "users";?>
						<li class="breadcrumb-item"><a href="<?=base_url("dashboard/$tip");?>"><?=$item->class == "admin" ? "Yöneticiler" : "Kullanıcılar"?></a></li>
						<li class="breadcrumb-item active">Düzenle</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<form action="<?php echo base_url("dashboard/do_update_user/$item->id")?>" method="post">
				<div class="card card-default">
					<div class="card-header">
						<h3 class="card-title">Kişisel Bilgiler</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
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
									<input type="text" class="form-control" name="userFN"  value="<?php echo $item_profile->ad;?>">
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
										<input type="text" class="form-control"  name="userPhone" data-inputmask='"mask": "(999) 999-9999"' data-mask placeholder="(999) 999-99-99"  value="<?php echo $item->phoneNumber;?>">
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
									<input type="text" class="form-control" name="userLN"  value="<?php echo $item_profile->soyad;?>">
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
										<input type="text" class="form-control"  name="userMail"  value="<?php echo $item->email;?>">
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
				<!-- /.card-body -->
				<div class="card card-default">
					<div class="card-header">
						<h3 class="card-title">Genel Bilgiler</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
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
										<input type="text" class="form-control"  name="userName"  value="<?php echo $item->userName;?>">
									</div>
								</div>
								<!-- /.form-group -->
								<div class="form-group">
									<label>Sicil No:</label>
									<?php if(isset($form_error)) { ?>
										<small class="input-form-error"><?php echo form_error("userSicil"); ?></small>
									<?php } ?>
									<input type="text" class="form-control" name="userSicil"  value="<?php echo $item->sicilNo;?>">
									<!-- /.input group -->
								</div>
								<!-- /.form-group -->
								<div class="form-group">
									<label for="ad">Fakülte No:</label>
									<?php if(isset($form_error)) { ?>
										<small class="input-form-error"><?php echo form_error("userF"); ?></small>
									<?php } ?>
									<input type="text" class="form-control" name="userF"  value="<?php echo $item_profile->fakulteNo;?>">
								</div>
							</div>
							<!-- /.col -->
							<div class="col-md-6">
								<!-- /.form-group -->
								<!-- /.form-group -->
								<div class="form-group">
									<label for="ad">Bolum No:</label>
									<?php if(isset($form_error)) { ?>
										<small class="input-form-error"><?php echo form_error("userB"); ?></small>
									<?php } ?>
									<input type="text" class="form-control" name="userB" value="<?php echo $item_profile->bolumNo;?>">
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
											<option value="NULL"<?=option_result($item->class, "NULL")?>>-----</option>
											<option value="admin"<?=option_result($item->class, "admin")?>>Admin</option>
											<option value="user" <?=option_result($item->class, "user")?>>Kullanıcı</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label for="ad">Unvan:</label>
									<?php if(isset($form_error)) { ?>
										<small class="input-form-error"><?php echo form_error("userUN"); ?></small>
									<?php } ?>
									<input type="text" class="form-control" name="userUN"  value="<?php echo $item_profile->unvan;?>">
								</div>
								<!-- /.form-group -->
							</div>
							<!-- /.col -->
						</div>
						<!-- /.row -->
					</div>
					<!-- /.row -->
				</div>
				<div class="card-footer">
					<div class="float-right">
						<a href="<?php echo base_url("dashboard/users");?>"><button type="button" class="btn bg-gradient-secondary">Geri</button></a>
						<button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Düzenle</button>
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

