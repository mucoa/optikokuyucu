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
			<p class="login-box-msg">Emailinizi girerek şifrenizi edinebilirsiniz.</p>
			<form action="<?=base_url("reset-password")?>" method="post">
				<?php if(isset($form_error)) { ?>
					<small class="input-form-error"><?php echo form_error("email"); ?></small>
				<?php } ?>
				<div class="input-group mb-3">
					<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo isset($form_error) ? set_value("email") : ""?>">
					<div class="input-group-append">
						<div class="input-group-text">
							<span class="fas fa-envelope"></span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<button type="submit" class="btn btn-dark btn-block">Gönder</button>
					</div>
					<!-- /.col -->
				</div>
			</form>
		</div>
</div>
</div>
<!-- /.login-box -->

</body>

