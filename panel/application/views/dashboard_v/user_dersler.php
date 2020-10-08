<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Tüm Derslerim</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Anasayfa</a></li>
						<li class="breadcrumb-item active">Derslerim</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Derslerim Tablosu</h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>

				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover dataTable js-exportable">
						<thead>
						<tr>
							<th>ID</th>
							<th>Ders Kodu</th>
							<th>Ders Adı</th>
							<th>Dönem</th>
							<th>Tarih</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($items as $item) { foreach ($aders as $ader) { if ($item->id == $ader->dersId) {?>
							<tr>
								<td><?=$item->id?></td>
								<td><?=$item->dersKodu?></td>
								<td><?=$item->dersAdi?></td>
								<td><?php foreach ($donem as $do) if ($item->donemId==$do->id){echo $do->yil."-->".$do->donem; break;}?></td>
								<td><?=$item->createDate?></td>
							</tr>
						<?php }}}?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- /.card-body -->
			<div class="card-footer">
				Bu sayfada sizin için açılmış dersler gösterilmektedir.
			</div>
			<!-- /.card-footer-->
		</div>
		<!-- /.card -->

	</section>
	<!-- /.content -->
</div>
