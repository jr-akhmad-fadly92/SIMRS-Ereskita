$(document).ready(function() {
	$('select[name="kategoriheader_id"]').on('change', function() {
		var prop_id = $(this).val();
		if(prop_id) {
				$.ajax({
						url: '/tarif/cek-split/'+prop_id,
						type: "GET",
						dataType: "json",
						success:function(data) {
							$('#count_split').empty();
							$.each(data, function(key, value) {
									$('#count_split').append('<div class="form-group"><label for="split" class="col-sm-3 control-label text-danger">'+value+'</label><div class="col-sm-9"><input type="text" name="split'+key+'" id=split"'+key+'" class="form-control" onkeyup="hitung_split()" /></div></div> <input type="hidden" name="jmlsplit" value="'+key+'" /> <input type="hidden" name="namasplit'+ key +'" value="'+ value +'" />');

							});
						}
				});
		}else{
				$('#count_split').empty();
		}
	});

	// GET ICD10 ===================================================================
	$(document).on('click', '.pilih', function (e) {
		document.getElementById("icd").value = $(this).attr('data-icd10');
		$('#myModal').modal('hide');
	});

	// SHOW PASIEN =================================================================
	$(document).on('click', '#pasienshow', function (e) {
		var id = $(this).attr('data-idpasien');
		$('#pasienModal').modal('show');
		$('#dataPasien').load("/pasien/"+id+"/show");
	});

	// SHOW NO RM   ================================================================
	$("#noRM").hide();
	$("#viewNoRM").click(function(e) {
		$("#noRM").show();
	});

	// SHOW HARGA RACIKAN ==========================================================
	$("#racikan").hide();
	$("#masterobat_id").on('change', function(e) {
		if( $("#masterobat_id").val() == '2268' ){
			$("#racikan").show();
		} else if ( $("#masterobat_id").val() != '2268' ) {
			$("#racikan").hide();
		}
	});

	//JADWAL DOKTER
	$('input[name="poli"]').on('focus', function () {
		$('#poliJadwal').modal('show');
	});

	$(document).on('click', '.addPoli', function (e) {
		document.getElementById("poli").value = $(this).attr('data-poli');
		$('#poliJadwal').modal('hide');
	});

	$('input[name="dokter"]').on('focus', function () {
		$('#dokterJadwal').modal('show');
	});

	$(document).on('click', '.addDokter', function (e) {
		document.getElementById("dokter").value = $(this).attr('data-dokter');
		$('#dokterJadwal').modal('hide');
	});
});