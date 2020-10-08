<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Bölüm Düzenle</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Anasayfa</a></li>
						<li class="breadcrumb-item"><a href="<?=base_url("dashboard/bolumler")?>">Bölümler</a></li>
						<li class="breadcrumb-item active">Bölüm Düzenle</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<form action="<?php echo base_url("dashboard/do_bolum_update/$itembol->id");?>" enctype="multipart/form-data" method="post">
				<div class="card card-default">
					<div class="card-header">
						<h3 class="card-title">Bölüm Bilgileri</h3>

						<div class="card-tools">
							<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
						</div>
					</div>
					<!-- /.card-header -->

					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="ad">Bölüm Adı:</label>
									<?php if(isset($form_error)) { ?>
										<small class="input-form-error"><?php echo form_error("bolumAdi"); ?></small>
									<?php } ?>
									<input type="text" class="form-control" name="bolumAdi"  value="<?=$itembol->bolumAdi;?>">
								</div>
								<!-- /.form-group -->
								<div class="form-group">
									<label>Fakülte:</label>
									<?php if(isset($form_error)) { ?>
										<small class="input-form-error"><?php echo form_error("fakulteId"); ?></small>
									<?php } ?>
									<select name="fakulteId" class="form-control">
										<option value="">----</option>
										<?php foreach ($items as $item) { ?>
											<option value="<?=$item->id?>"<?=option_result($itembol->fakulteId, $item->id)?>><?=$item->fakulteKodu."-->".$item->fakulteAdi;?></option>
										<?php } ?>
									</select>
								</div>
								<!-- /.form-group -->
							</div>
							<!-- /.col -->
							<div class="col-md-6">
								<div class="form-group">
									<label for="ad">Bölüm Kodu:</label>
									<?php if(isset($form_error)) { ?>
										<small class="input-form-error"><?php echo form_error("bolumKodu"); ?></small>
									<?php } ?>
									<input type="text" class="form-control" name="bolumKodu" value="<?=$itembol->bolumKodu;?>">
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
				<a href="<?php echo base_url("dashboard/bolumler");?>"><button type="button" class="btn bg-gradient-secondary">Geri</button></a>
				<button type="submit" class="btn bg-gradient-teal"><i class="fas fa-edit"></i> Düzenle</button>
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
