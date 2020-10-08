<body class="hold-transition login-page" style="background-image: url(<?= base_url("assets");?>/dist/img/background.jpg); background-repeat: no-repeat;">
<div class="login-box">
	<div class="login-logo">
		<img src="<?= base_url("assets");?>/dist/img/logo.jpg"
			 alt="Kocaeli Üniversitesi Logo"
			 class="brand-image img-circle elevation-3"
			 style="opacity: .8" width="200" height="200"><div  style="color: #fff;">
			<b>Kocaeli</b>Üniversitesi
		</div>
	</div>
	<!-- /.login-logo -->
	<div class="card" style="opacity: .8">
		<div class="card-body login-card-body">
			<p class="login-box-msg">Giriş yaparak oturumunuzu açınız.</p>
			<form action="<?=base_url("userop/do_login")?>" method="post">
				<?php if(isset($form_error)) { ?>
				<small class="input-form-error"><?php echo form_error("userN"); ?></small>
				<?php } ?>
				<div class="input-group mb-3">
					<input type="text" class="form-control" placeholder="Kullanıcı Adı" name="userN">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-user"></span>
						</div>
					</div>
				</div>
				<?php if(isset($form_error)) { ?>
				<small class="input-form-error"><?php echo form_error("userPass"); ?></small>
				<?php } ?>
				<div class="input-group mb-3">
					<input type="password" class="form-control" placeholder="Şifre" name="userPass">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-lock"></span>
						</div>
					</div>
				</div>
					<div class="col-4">
						<button type="submit" class="btn btn-dark btn-block">Giriş</button>
					</div>
				</div>
			</form>
			<p class="mb-2 mr-2">
				<a href="<?=base_url("sifremi-unuttum")?>" style="float: right; color: limegreen"> Şifremi unuttum</a>
			</p>
		</div>

	</div>
</div>
<!-- /.login-box -->

</body>

