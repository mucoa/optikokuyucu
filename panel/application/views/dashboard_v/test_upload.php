<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Test Giriş</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Anasayfa</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url("dashboard/test");?>">Test Giriş</a></li>
						<li class="breadcrumb-item active">Test Dosya Giriş</a></li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<form action="<?=base_url("dashboard/upload_test")?>" enctype="multipart/form-data" method="post">
				<div class="card card-default">
					<div class="card-header">
						<h3 class="card-title">Test Dosya Girişi</h3>

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
									<label for="exampleInputFile">Test dosyasını seçiniz:</label>
									<?php if(isset($file_error) && $file_error == true) { ?>
										<small class="input-form-error"><?php echo "Sadece .txt uzantılı dosya kabul edilmektedir, dosyanızı kontrol edin!"; ?></small>
									<?php } ?>
									<div class="input-group">
										<div class="custom-file">
											<input type="file" name="userFile" class="custom-file-input" id="exampleInputFile">
											<label class="custom-file-label" for="exampleInputFile">Metin dosyası girişi --></label>
										</div>
										<div class="input-group-append">
											<span class="input-group-text" id="">Yükle</span>
										</div>
									</div>
								</div>
							</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="exampleInputFile">Cevap dosyasını seçiniz:</label>
										<?php if(isset($file_error) && $file_error == true) { ?>
											<small class="input-form-error"><?php echo "Sadece .txt uzantılı dosya kabul edilmektedir, dosyanızı kontrol edin!"; ?></small>
										<?php } ?>
										<div class="input-group">
											<div class="custom-file">
												<input type="file" name="userFile2" class="custom-file-input" id="exampleInputFile">
												<label class="custom-file-label" for="exampleInputFile">Metin dosyası test cevap girişi için tıklayınız</label>
											</div>
											<div class="input-group-append">
												<span class="input-group-text" id="">Yükle</span>
											</div>
										</div>
								</div>
								<input type="hidden" name="sinavTur" value="<?=$sinavTur?>">
								<input type="hidden" name="sinavDers" value="<?=$sinavDers?>">
								<input type="hidden" name="sinavBol" value="<?=$sinavBol?>">
							</div>

							<!-- /.col -->

						<!-- /.row -->
					</div>
					<!-- /.row -->
				</div>

		</div>
		<div class="card-footer">
			<div class="float-right">
				<a href="<?php echo base_url("dashboard/test");?>"><button type="button" class="btn bg-gradient-secondary">Geri</button></a>
				<button type="submit" class="btn bg-gradient-teal"><i class="fas fa-check"></i> Devam</button>
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
