@extends('master')
@section('header')
  <h1>Informasi Rawat Inap<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
        <div class='table-responsive'>
          <table id="dataIrna" class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr>
                <th class="text-center" style="vertical-align: middle;">#</th>
                <th class="text-center" style="vertical-align: middle;">No. RM</th>
                <th class="text-center" style="vertical-align: middle;">Nama Pasien</th>
                <th class="text-center" style="vertical-align: middle;">Alamat</th>
                <th class="text-center" style="vertical-align: middle;">Tanggal Masuk</th>
                <th class="text-center" style="vertical-align: middle;">Durasi</th>
                <th class="text-center" style="vertical-align: middle;">Kelas</th>
                <th class="text-center" style="vertical-align: middle;">Bangsal</th>
                <th class="text-center" style="vertical-align: middle;">Bed</th>
                <th class="text-center" style="vertical-align: middle;">DPJP</th>
                <th class="text-center" style="vertical-align: middle;">Cara Bayar</th>
                <!--th class="text-center" style="vertical-align: middle;">View</th-->
              </tr>
            </thead>
            <tbody> </tbody>
          </table>
        </div>
    </div>
  </div>
@endsection


@section('script')
<script type="text/javascript">
	//SHOW DATA
	var table;
	table = $('#dataIrna').DataTable({
		"language": {
				"url": "json/pasien.datatable-language.json",
		},
		paging      : true,
		iDisplayLength : 25,
		lengthChange: true,
		searching   : true,
		ordering    : true,
		info        : false,
		autoWidth   : false,
		destroy     : true,
		processing  : true,
		serverSide  : true,
		ajax: '/data-rawat-inap',
		fnCreatedRow: function (row, data, index) {
			$('td', row).eq(0).html(index + 1);
		},
		columns: [
			{data: 'nomor'},
			{data: 'no_rm'},
			{data: 'nama'},
			{data: 'alamat'},
			{data: 'waktu'},
			{data: 'durasi'},
			{data: 'kelas'},
			{data: 'bangsal'},
			{data: 'bed'},
			{data: 'dpjp'},
			{data: 'carabayar'},
			//{data: 'view'},
		]
	});

	//DETAIL IRNA
	function viewDetail(registrasi_id) {
		$('#detailIrna').modal('show');
		$('.modal-title').text('Detail Informasi Rawat Inap');
		$.ajax({
			url: '/detail-data-rawat-inap/'+registrasi_id,
			type: 'GET',
			dataType: 'json',
			success: function (data) {
				$('#no_rm').html(data.no_rm);
				$('#nama').html(data.nama);
				$('#alamat').html(data.alamat);
				$('#tgl_masuk').html(data.tgl_masuk);
				$('#carabayar').html(data.carabayar);
				$('#dokter').html(data.dokter);
				$('#kelas').html(data.kelas);
				$('#kamar').html(data.kamar);
				$('#bed').html(data.bed);
			}
		});
	}
</script>
@endsection
