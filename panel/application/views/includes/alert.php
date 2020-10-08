<?php
$alert = $this->session->userdata("alert");
if ($alert) {
	if ($alert["type"] === "success") {?>

		<script>
            Toast.fire({
                icon: 'success',
                title: '<?php echo $alert["text"];?>'
            })
		</script>

	<?php } else { ?>

		<script>
            Toast.fire({
                icon: 'error',
                title: '<?php echo $alert["text"];?>'
            })
		</script>

	<?php }
}?>
