$(".remove-btn").click(function () {

	var $data_url = $(this).data("url");

	const swalWithBootstrapButtons = Swal.mixin({
		customClass: {
			confirmButton: 'btn btn-success',
			cancelButton: 'btn btn-danger mr-2'
		},
		buttonsStyling: false
	})

	swalWithBootstrapButtons.fire({
		title: 'Emin misiniz?',
		text: "Bu işlem geri alamayacaksınız!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonText: 'Evet, sil!',
		cancelButtonText: 'Hayır, iptal!',
		reverseButtons: true
	}).then((result) => {
		if (result.value) {
			window.location.href = $data_url;
		} else if (
			/* Read more about handling dismissals below */
			result.dismiss === Swal.DismissReason.cancel
		) {
			swalWithBootstrapButtons.fire(
				'İptal edildi',
				'Kullanıcı ile ilgili hiçbir değişiklik yapılmadı.',
				'error'
			)
		}
	})
});

// Aktif Pasif durumu
$(".isActive").change(function(){

	var $data = $(this).prop("checked");
	var $data_url = $(this).data("url");

	if (typeof $data !== "undefined" && typeof $data_url !== "undefined"){

		$.post($data_url, { data : $data }, function (response) {
			alert("Durum değiştirildi!");
		});
	}

});
