@extends('master')
@section('header')
  <h1>Admission </h1>
@endsection

@section('content')
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">
			@role(['supervisor-costing','costing','administrator','supervisor']) Buat SEP Ranap @else Antrian Rawat Inap @endrole
		</h3>
	</div>
	<div class="box-body">
		<div class='table-responsive'>
			<table class='table table-striped table-bordered table-hover table-condensed' id='data'>
				<thead>
					<tr>
						<th>No</th>
						<th>No. RM</th>
						<th>Nama</th>
						<th>Cara Bayar</th>
						<th>Asal Klinik</th>
						<th>DPJP</th>
						<th>Tgl Antrian</th>
						<th>Proses</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($antrian as $key => $d)
						<tr>
							<td>{{ $no++ }}</td>
							<td>{{ $d->pasien->no_rm }}</td>
							<td>{{ $d->pasien->nama }}</td>
							<td>{{ baca_carabayar($d->bayar) }} {{ (!empty($d->tipe_jkn)) ? ' - '.$d->tipe_jkn : '' }}</td>
							<td>{{ $d->poli->nama }}</td>
							<td>{{ baca_dokter($d->dokter_id) }}</td>
							<td>{{ $d->updated_at }}</td>
							<td>
								<button type="button" data-id="{{ $d->id }}" class="btn btn-primary btn-sm openForm" name="button"><i class="fa fa-refresh"></i></button>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>


<div class="modal fade" id="antrianIRNA" role="dialog" aria-labelledby="" aria-hidden="true" style="overflow-x: hidden!important;overflow-y: auto!important;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
			@role('rawatinap')
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id=""></h4>
      </div>
			@endrole
      <div class="modal-body">
        <h4 id="error" class="text-danger text-center"></h4>
				@role(['supervisor-costing','costing'])
					@include('frontoffice.v-claim.form-sep-ranap')    
				@else
					@include('rawat-inap.form_antrian')    
				@endrole
      </div>
    </div>
  </div>
</div>

{{-- MODAL DIAGNOSA --}}
<div class="modal fade" id="ICD10" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id=""></h4>
        </div>
        <div class="modal-body">
          <div class='table-responsive'>
            <table id='dataICD10' class='table table-striped table-bordered table-hover table-condensed'>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Add</th>
                </tr>
              </thead>

            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@stop

@section('script')
<script type="text/javascript">
	$(".select2").select2();	
	setTimeout(function(){
		$("#laka").hide();
		$(".chosen-container").css("width","100%");
	}, 100);
	function chLaka(val){
		if(val==1){
			$("#laka").show();
		}else{
			$("#laka").hide();
		}
	}
  $('.openForm').on('click', function () {
    $('#antrianIRNA').modal('show');
    $('.modal-title').text('Pilih Kamar');
    $('#kelas_id-error').html("");
    $('#kamar_id-error').html("");
    $('#bed_id-error').html("");
    $('#kamarID').removeClass('has-error');
    $('#bedID').removeClass('has-error');
    $("#Register")[0].reset();
    $('.select2').select2();

    $.ajax({
      url: '/rawat-inap/get-datareg/'+$(this).attr('data-id')+'',
      type: 'GET',
      success : function (data) {
        $('input[name="namaPasien"]').val(data.nama);
        $('input[name="no_rm"]').val(data.no_rm);
        $('input[name="caraBayar"]').val(data.pembayaran);
        $('input[name="registrasi_id"]').val(data.id);
        $('input[name="carabayar_id"]').val(data.bayar);
        $('input[name="catatan_bpjs"]').val(data.no_rm)
        $('input[name="status_reg"]').val(data.status_reg)
        $('input[name="no_bpjs_search"]').val(data.no_jkn)
        $('input[name="no_tlp"]').val(data.nohp)
        $('input[name="no_surat_kontrol"]').val(data.no_surat_kontrol)
        $('input[name="no_rujukan_ranap"]').val(data.no_rujukan)

        $('#kelompokkelas_idGroup').removeClass('has-error')
        $('#kelompokkelas_idError').html('');
        $('#kelas_idGroup').removeClass('has-error')
        $('#kelas_idError').html('');
        $('#kamaridGroup').removeClass('has-error');
        $('#kamaridError').html('');
        $('#bedID').removeClass('has-error');
        $('#bed_id-error').html('');
        $('#statusNoJKN').removeClass('has-error');
        $('#statusNoJKN').removeClass('has-success');
        $('#cekStatus').removeClass('btn-danger')
        $('.fa').removeClass('fa-check');
        $('.fa').removeClass('fa-remove');

        if(data.bayar == 1){
					if(data.kode!=''){
						$('select[name="dokter_id"]').val(data.dokter_id);
						$('select[name="dokter_id"]').trigger("change");
					}
					$('input[name="poli_bpjs"]').val(data.poli_bpjs)
          $('#pasienJKN').removeClass('hidden');
          $('input[name="no_bpjs"]').val(data.no_jkn);
        }else{
          $('#pasienJKN').addClass('hidden');
        }
      }
    });
  });

// Form Submit
  $('#submitForm').on('click', function () {
		var registerForm = $("#Register");
		var formData = registerForm.serialize();
		$.ajax({
			url: '/rawatinap/save',
			type: 'POST',
			data: formData,
			success: function (data) {
				console.log(data);
				if(data.errors) {
					if (data.errors.dokter_id) {
						$( '#dokter_idGroup' ).addClass('has-error')
						$( '#dokter_idError' ).html( data.errors.dokter_id[0] );
					}
					if (data.errors.kelompokkelas_id) {
						$( '#kelompokkelas_idGroup' ).addClass('has-error')
						$( '#kelompokkelas_idError' ).html( data.errors.kelompokkelas_id[0] );
					}
					if(data.errors.kelas_id){
						$( '#kelas_idGroup' ).addClass('has-error')
						$( '#kelas_idError' ).html( data.errors.kelas_id[0] );
					}
					if(data.errors.kamarid){
						$('#kamaridGroup').addClass('has-error');
						$('#kamaridError').html( data.errors.kamarid[0] );
					}
					if(data.errors.bed_id){
						$('#bedID').addClass('has-error');
						$('#bed_id-error' ).html( data.errors.bed_id[0] );
					}
				};
				if (data.success == 1) {
					if(data.bayar==1){
						if(data.sep!=null){
							window.open('/cetak-sep/'+data.sep,'popUpWindow','height=400,width=600,left=10,top=10,,scrollbars=yes,menubar=no');
						}
					}
					location.href='/admission';
					$('#antrianIRNA').modal('hide');
				}
				if(data.error == true){
					$('#error').html(data.pesan)
				}
			}
		});
  });
	$('#submitSepRanap').on('click', function () {
		var registerForm = $("#Register");
		var formData = registerForm.serialize();
		$.ajax({
			url: '/registrasi/v-claim/simpan-sep',
			type: 'POST',
			data: formData,
			success: function (data){
				if(data.success){
					if(data.bayar==1){
						if(data.sep!=null){
							window.open('/cetak-sep/'+data.sep,'popUpWindow','height=400,width=600,left=10,top=10,,scrollbars=yes,menubar=no');
						}
					}
					location.href='/frontoffice/v-claim/sep-ri';
					$('#antrianIRNA').modal('hide');
				}else{
					alert('Gagal simpan SEP rawat inap')
				}
			}
		});
  });
</script>

{{-- Pengaturan Kelas --}}
<script type="text/javascript">
  $('select[name="kelas_id"]').on('change', function(e) {
    e.preventDefault();
    var kelompokkelas_id = $('select[name="kelompokkelas_id"]').val()
    var kelas_id = $(this).val();
		$('select[name="bed_id"]').empty()
		$('select[name="kamarid"]').empty()
		$('select[name="kamarid"]').append('<option value=""></option>');
    $.ajax({
      url: '/kamar/getkamar/'+kelompokkelas_id+'/'+kelas_id,
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        $.each(data, function(key, value) {
          $('select[name="kamarid"]').append('<option value="'+ value.id +'">'+ value.nama +'</option>');
        });
      }
    })
  })

  $('select[name="kamarid"]').on('change', function(e) {
    e.preventDefault();
    var kelompokkelas_id = $('select[name="kelompokkelas_id"]').val()
    var kelas_id = $('select[name="kelas_id"]').val()
    var kamar_id = $(this).val()
		$('select[name="bed_id"]').empty()
    $.ajax({
      url: '/getbed/'+kelompokkelas_id+'/'+kelas_id+'/'+kamar_id+'/',
      type: 'GET',
      dataType: 'json',
      success: function (data) {
        console.log(data);
        $.each(data, function(key, value) {
          $('select[name="bed_id"]').append('<option value="'+ key +'">'+ value +'</option>');
        });
      }
    })
  });

  //CEK STATUS JKN
  $('input[name="no_bpjs_search"]').keyup(function() {
    $('#statusNoJKN').removeClass('has-error');
    $('#statusNoJKN').removeClass('has-success');
    $('.fa').removeClass('fa-remove')
    $('.fa').removeClass('fa-check')
    $('#cekStatus').removeClass('btn-danger')
    $('#cekStatus').addClass('btn-success')
  });

  $('#cekStatus').on('click',  function(e) {
    e.preventDefault();
    var no_kartu = $('input[name="no_bpjs_search"]').val();
    var registrasi_id = $('input[name="registrasi_id"]').val();
    var status_reg = $('input[name="status_reg"]').val();
    var poli_bpjs = $('input[name="poli_bpjs"]').val();
		if(no_kartu==""){
			alert("Nomor JKN harus diisi");
			return false;
		}
		$('.progress').removeClass('hidden')
    $.ajax({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
      url: '/registrasi/v-claim/cari-peserta',
      type: 'POST',
      dataType: 'json',
			data: {nomor: no_kartu, status_reg: status_reg, poli_bpjs: poli_bpjs, jsonx: true},
      success: function (data) {
        console.log(data);
				$('.progress').addClass('hidden')
        if(data.status){
					if(data.data.keterangan == 'AKTIF'){
						$('#statusNoJKN').removeClass('has-error');
						$('#statusNoJKN').addClass('has-success');
						$('#cekStatus').removeClass('btn-danger')
						$('#cekStatus').addClass('btn-success')
						$('.fa').removeClass('fa-remove')
						$('.fa').addClass('fa-check')
						
						//INSERT RETURN TO FORM
						//$('input[name="tgl_rujukan"]').val(data.data.tgl_rujukan)
						$('input[name="tgl_rujukan"]').val('')
						$('input[name="ppk_rujukan"]').val(data.data.kd_ppk)
						//$('input[name="ppk_rujukan_text"]').val(data.data.kd_ppk+' / '+data.data.nama_ppk)
						$('input[name="ppk_rujukan_text"]').val('')
						//$('select[name="asalRujukan"]').val(data.data.asal_rujukan)
						$('input[name="hak_kelas_default"]').val(data.data.hak_kelas)
						$('select[name="hak_kelas"]').val(data.data.hak_kelas)
						$('input[name="cob"]').val(data.data.cob)
						var cob = "Ya";
						if(data.data.cob==0){
							cob = "Tidak";
						}
						$('input[name="cob_text"]').val(cob)
						$('input[name="no_bpjs"]').val(data.data.no_kartu)
						//$('input[name="no_rujukan"]').val(data.data.no_rujukan)
						
						$('select[name="kode_dpjp"]').html('');
						$('select[name="kode_dpjp"]').append('<option value=""></option>');
						if(data.data.dokter_dpjp!=null){
							$.each(data.data.dokter_dpjp, function(key, value) {
								$('select[name="kode_dpjp"]').append('<option value="'+ value.kode +'">'+ value.nama.toUpperCase() +'</option>');
							});
							$('select[name="kode_dpjp"]').trigger("chosen:updated");
						}
						if(data.data.provinsi!=null){
							$.each(data.data.provinsi, function(key, value) {
								$('select[name="bpjs_province_id"]').append('<option value="'+ value.kode +'">'+ value.nama +'</option>');
							});
							$('select[name="bpjs_province_id"]').trigger("chosen:updated");
						}
					}else{
						alert("Nomor JKN tidak aktif");
						$('#statusNoJKN').removeClass('has-success');
						$('#statusNoJKN').addClass('has-error');
						$('#cekStatus').addClass('btn-danger')
						$('.fa').addClass('fa-remove')
					}
        }else{
					alert("Nomor JKN tidak ditemukan");
          $('#statusNoJKN').removeClass('has-success');
          $('#statusNoJKN').addClass('has-error');
          $('#cekStatus').addClass('btn-danger')
          $('.fa').addClass('fa-remove')
        }
      }
    });    
  });

	// ADD DIAGNOSA
  $('input[name="diagnosa_awal"]').focus(function(e) {
    e.preventDefault();
    $("#dataICD10").DataTable().destroy()
        $("#ICD10").modal('show');
        $('#dataICD10').DataTable({
            "language": {
                "url": "/json/pasien.datatable-language.json",
            },
            pageLength: 10,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ordering: false,
            ajax: '/sep/geticd10',
            columns: [
                // {data: 'rownum', orderable: false, searchable: false},
                {data: 'id'},
                {data: 'nomor'},
                {data: 'nama'},
                {data: 'add', searchable: false}
            ]
        });
  });

  $(document).on('click', '.addICD', function (e) {
    e.preventDefault();
    document.getElementById("diagnosa_awal").value = $(this).attr('data-nomor');
    document.getElementById("diagnosa_text").value = $(this).attr('data-nama');
    $('#ICD10').modal('hide');
  });

  //CREATE SEP
  $('#createSEP').on('click', function (){
		$.ajax({
			url : '{{ url('/buat-sep') }}',
			type: 'POST',
			data: $("#Register").serialize(),
			processing: true,
			beforeSend: function () {
				$('.progress').removeClass('hidden')
			},
			complete: function () {
				$('.progress').addClass('hidden')
			},
			success:function(data){
				console.log(data);
				if(data.sukses){
					$('#fieldSEP').removeClass('has-error');
					$("input[name='no_sep']").val(data.sukses);
				} else if (data.msg) {
					alert(data.msg);
					$('#fieldSEP').addClass('has-error');
					$("input[name='no_sep']").val(data.msg);
				}
			}
		});
	});
</script>
@endsection