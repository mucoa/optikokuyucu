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
						<li class="breadcrumb-item active"><a href="<?=base_url("dashboard/test");?>">Test Giriş</a></li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<form action="<?php echo base_url("dashboard/test_add");?>" method="post">
				<div class="card card-default">
					<div class="card-header">
						<h3 class="card-title">Test Bilgileri</h3>

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
									<label>Bölüm:</label>
									<?php if(isset($form_error)) { ?>
										<small class="input-form-error"><?php echo form_error("sinavBol"); ?></small>
									<?php } ?>
									<select class="form-control" name="sinavBol">
										<option value="">----</option>
										<?php foreach ($bolum as $bol){ ?>
											<option value="<?=$bol->id?>" <?php echo isset($form_error) ? option_result(set_value("sinavBol"), $bol->id) : ""?>><?=$bol->bolumAdi?></option>
										<?php }?>
									</select>
								</div>
								<!-- /.form-group -->
								<div class="form-group">
									<label for="ad">Sınav Türü:</label>
									<?php if(isset($form_error)) { ?>
										<small class="input-form-error"><?php echo form_error("sinavTur"); ?></small>
									<?php } ?>
									<select class="form-control" name="sinavTur">
										<option value="">----</option>
										<option value="V" <?php echo isset($form_error) ? option_result(set_value("sinavTur"), "V") : ""?>>Vize</option>
										<option value="F"  <?php echo isset($form_error) ? option_result(set_value("sinavTur"), "F") : ""?>>Final</option>
										<option value="B"  <?php echo isset($form_error) ? option_result(set_value("sinavTur"), "B") : ""?>>Bütünleme</option>
									</select>
								</div>
								<!-- /.form-group -->
							</div>
							<!-- /.col -->
							<div class="col-md-6">
								<div class="form-group">
									<label>Dersler:</label>
									<?php if(isset($form_error)) { ?>
										<small class="input-form-error"><?php echo form_error("sinavDers"); ?></small>
									<?php } ?>
									<select name="sinavDers" class="form-control">
										<option value="">----</option>
										<?php foreach ($ders as $der) { foreach ($aders as $ader){ if ($der->id == $ader->dersId) {?>
											<option value="<?=$der->id?>" <?php echo isset($form_error) ? option_result(set_value("sinavDers"), $der->id) : ""?>>
												<?php foreach ($donem as $done){ if ($done->id == $der->donemId) echo $done->yil."-".$done->donem."-->".$der->dersAdi;}?>
											</option>
										<?php }}} ?>
									</select>
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
				<a href="<?php echo base_url();?>"><button type="button" class="btn bg-gradient-secondary">Geri</button></a>
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
