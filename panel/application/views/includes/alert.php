<?php
$alert = $this->session->userdata("alert");
if ($alert) {
	if ($alert["type"] === "success") {?>

		<script>
			toastr.success('<?=$alert["text"]?>');
		</script>

	<?php } else { ?>

		<script>
            toastr.error('<?=$alert["text"]?>');
		</script>

	<?php }
}?>
