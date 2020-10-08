<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Kullanıcılar</h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=base_url();?>">Anasayfa</a></li>
						<li class="breadcrumb-item active">Kullanıcılar</li>
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
				<h3 class="card-title">Kullanıcı Tablosu</h3>

				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i></button>
				</div>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered table-striped table-hover dataTable js-exportable">
						<thead>
						<tr>
							<th>ID</th>
							<th>AdSoyad</th>
							<th>SicilNo</th>
							<th>Telefon Numarası</th>
							<th>Mail</th>
							<th>Durum</th>
							<th>Tarih</th>
							<th>İşlemler</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($items as $item) {?>
							<tr>
								<td><?=$item->id?></td>
								<td><?php foreach ($profiles as $profile) if ($item->id==$profile->userId){echo ucfirst($profile->ad)." ".ucfirst($profile->soyad); break;}?></td>
								<td><?=$item->sicilNo?></td>
								<td><?=$item->phoneNumber?></td>
								<td><?=$item->email?></td>
								<td><div class="switch">
										<label><input data-url="<?php echo base_url("dashboard/isActiveSetter/$item->id/user")?>" class="isActive" type="checkbox" <?php echo ($item->isActive=="A") ? "checked" : "";  ?>><span class="lever switch-col-teal"></span></label>
									</div></td>
								<td><?=$item->createDate?></td>
								<td><a href="<?php echo base_url("dashboard/update_user/$item->id")?>"><button type="button" class="btn btn-outline-primary" style="text-align: center">
											<i class="fas fa-edit"></i>
										</button></a><button data-url="<?php echo base_url("dashboard/delete_user/$item->id")?>" class="btn btn-outline-danger remove-btn ml-2">
										<i class="fas fa-trash"></i>
									</button>
								</td>
							</tr>
						<?php }?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- /.card-body -->
			<div class="card-footer">
				<a href="<?=base_url("dashboard/new_user")?>"><button class="btn btn-sm btn-success float-right"><i class="fas fa-user-plus"></i> Ekle</button></a>
			</div>
			<!-- /.card-footer-->
		</div>
		<!-- /.card -->

	</section>
	<!-- /.content -->
</div>

