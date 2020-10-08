<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Profilim</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Anasayfa</a></li>
						<li class="breadcrumb-item active">Profil</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-3">

					<!-- Profile Image -->
					<div class="card card-primary card-outline">
						<div class="card-body box-profile">
							<div class="text-center">
								<img class="profile-user-img img-fluid img-circle"
									 src="<?=base_url("assets");?>/userImages/<?=$profile->resim;?>"
									 alt="User profile picture">
							</div>

							<h3 class="profile-username text-center"><?=$profile->unvan." ".$profile->ad." ".$profile->soyad?></h3>

							<p class="text-muted text-center"><?=$item_fak->fakulteAdi;?></p>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
				<!-- /.col -->
				<div class="col-md-9">
					<div class="card">
						<div class="card-header p-2">
							<ul class="nav nav-pills">
								<?php if(isset($swicthtopass)) { ?>
								<li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Profil</a></li>
								<li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Şifre</a></li>
								<?php }else{ ?>
									<li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Profil</a></li>
									<li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Şifre</a></li>
								<?php } ?>
							</ul>
						</div><!-- /.card-header -->
						<div class="card-body">
							<div class="tab-content">
								<?php if(isset($swicthtopass)) { ?>
								<div class="tab-pane" id="settings">
									<?php }else{ ?>
									<div class="active tab-pane" id="settings">
										<?php } ?>
									<form class="form-horizontal" action="<?=base_url("dashboard/profileup")?>" method="post">
										<div class="form-group row">
											<label for="inputName" class="col-sm-2 col-form-label">Ad</label>
											<?php if(isset($form_error)) { ?>
												<small class="input-form-error"><?php echo form_error("userFN"); ?></small>
											<?php } ?>
											<div class="col-sm-10">
												<input type="text" name="userFN" class="form-control" value="<?=$profile->ad?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Soyad</label>
											<?php if(isset($form_error)) { ?>
												<small class="input-form-error"><?php echo form_error("userLN"); ?></small>
											<?php } ?>
											<div class="col-sm-10">
												<input type="text" name="userLN" class="form-control" value="<?=$profile->soyad?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Email</label>
											<?php if(isset($form_error)) { ?>
												<small class="input-form-error"><?php echo form_error("userMail"); ?></small>
											<?php } ?>
											<div class="col-sm-10">
												<input type="email" name="userMail" class="form-control" value="<?=$item->email?>">
											</div>
										</div>
										<div class="form-group row">
											<label  class="col-sm-2 col-form-label">Telefon Numarası</label>
											<?php if(isset($form_error)) { ?>
												<small class="input-form-error"><?php echo form_error("userPhone"); ?></small>
											<?php } ?>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="userPhone" placeholder="Experience" value="<?=$item->phoneNumber?>">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Unvan</label>
											<?php if(isset($form_error)) { ?>
												<small class="input-form-error"><?php echo form_error("userUN"); ?></small>
											<?php } ?>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="userUN" placeholder="Skills" value="<?=$profile->unvan?>">
											</div>
										</div>
										<div class="form-group row">
											<div class="offset-sm-2 col-sm-10">
												<button type="submit" class="btn btn-danger"><i class="fas fa-edit mr-2"></i>Düzenle</button>
											</div>
										</div>
									</form>
								</div>
								<?php if(isset($swicthtopass)) { ?>
								<div class="active tab-pane" id="activity">
									<?php }else{ ?>
									<div class="tab-pane" id="activity">
										<?php } ?>
									<form class="form-horizontal" action="<?=base_url("dashboard/passchange")?>" method="post">
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Yeni Şifre</label>
											<?php if(isset($form_error)) { ?>
												<small class="input-form-error"><?php echo form_error("userNP"); ?></small>
											<?php } ?>
											<div class="col-sm-10">
												<input type="password" name="userNP" class="form-control">
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Yeni Şifre Doğrulama</label>
											<?php if(isset($form_error)) { ?>
												<small class="input-form-error"><?php echo form_error("userNPC"); ?></small>
											<?php } ?>
											<div class="col-sm-10">
												<input type="password" name="userNPC" class="form-control">
											</div>
										</div>
										<div class="form-group row">
											<div class="offset-sm-2 col-sm-10">
												<button type="submit" class="btn btn-danger"><i class="fas fa-lock mr-2"></i>Değiştir</button>
											</div>
										</div>
									</form>
								</div>
								<!-- /.tab-pane -->
							</div>
							<!-- /.tab-content -->
						</div><!-- /.card-body -->
					</div>
					<!-- /.nav-tabs-custom -->
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div><!-- /.container-fluid -->
	</section>
</div>

<!-- Default box -->
<!-- /.card -->
</section>
<!-- /.content -->
</div>

