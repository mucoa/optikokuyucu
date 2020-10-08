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
						<li class="breadcrumb-item active">Dosya Çıktısı</a></li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<div class="card card-default">
				<div class="card-header">
					<h3 class="card-title">Metin Çıktısı</h3>

					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
						<button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
					</div>
				</div>
				<!-- /.card-header -->

				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover dataTable js-exportable">
							<thead>
							<tr>
								<th>Öğrenci No</th>
								<th>AdSoyad</th>
								<th>Not</th>
								<th>Sonuçlar</th>
							</tr>
							</thead>
							<tbody>
							<?php for ($i = 0; $i<sizeof($ogr_ad); $i++) {?>
								<tr>
									<td><?=$ogr_num[$i];?></td>
									<td><?=$ogr_ad[$i];?></td>
									<td><?=$ogr_not[$i];?></td>
									<td><?=$ogr_dy[$i];?></td>
								</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
					<!-- /.row -->
				</div>
				<!-- /.row -->
			</div>
			<form action="<?=base_url("dashboard/match_test")?>" method="post">
				<input type="hidden" name="sinavTur" value="<?=$sinavTur?>">
				<input type="hidden" name="path" value="<?=$path?>">
				<input type="hidden" name="sinavDers" value="<?=$sinavDers?>">
				<input type="hidden" name="sinavBol" value="<?=$sinavBol?>">
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
