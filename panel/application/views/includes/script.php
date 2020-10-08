<!-- jQuery -->
<script src="<?=base_url("assets")?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url("assets")?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url("assets")?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url("assets")?>/dist/js/demo.js"></script>
<!-- InputMask -->
<script src="<?=base_url("assets")?>/plugins/moment/moment.min.js"></script>
<script src="<?=base_url("assets")?>/plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?=base_url("assets")?>/plugins/select2/js/select2.full.min.js"></script>
<!-- Jquery DataTable Plugin Js -->
<script src="<?=base_url("assets")?>/plugins/jquery-datatable/jquery.dataTables.js"></script>
<script src="<?=base_url("assets")?>/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
<script src="<?=base_url("assets")?>/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
<script src="<?=base_url("assets")?>/plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
<script src="<?=base_url("assets")?>/plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
<script src="<?=base_url("assets")?>/plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
<script src="<?=base_url("assets")?>/plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
<script src="<?=base_url("assets")?>/plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
<script src="<?=base_url("assets")?>/plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>
<!--Custom datatable-->
<script src="<?=base_url("assets")?>/dist/js/pages/tables/jquery-datatable.js"></script>
<!-- SweetAlert2 -->
<script src="<?=base_url("assets")?>/plugins/sweetalert2new/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=base_url("assets")?>/plugins/toastr/toastr.min.js"></script>
<!-- Custom -->
<script src="<?=base_url("assets")?>/dist/js/custom.js"></script>
<!--Sweetalert settings-->
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>

<!--Sweetalert alert-->
<?php $this->load->view("includes/alert");?>
