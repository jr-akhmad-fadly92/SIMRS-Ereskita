
@extends('master')

@section('head')

@endsection
@section('header')

  <h1>Detail Akun {{$namaakun->nama_akun}}</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      Detail Akun {{$namaakun->nama_akun}}&nbsp;
      </h3>
      <a href="{{url('/keuangan/buku-besar/'.$akun)}}" class="btn btn-success">Back</a><hr>
    </div>
    <div class="box-body">
        <div class='table-responsive col-md-12'>
        <h4>Data Akun Bulan {{ $bulan }}</h4>
          <table class='table table-striped table-bordered table-hover table-condensed' id="datajurnal">
          
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Nama Akun</th>
                <th>Kode</th>
                <th>Keterangan</th>
                <th>Debet</th>
                <th>Kredit</th>
               
              </tr>
            </thead>
            <tbody>
            
            </tbody>
              
          </table>
          <h4 style="font-weight: bold;">
          Total
          </h4>
          <table class='table table-striped table-bordered table-hover table-condensed text-center' style="font-weight: bold;font-size:12;" id="datatotal">
          
            <thead>
              <tr>
                <th>Debet</th>
                <th>Kredit</th>
                
              </tr>
            </thead>
            <tbody>
              <tr style="font-weight: bold;font-size:12;">
                <td>Rp. {{number_format($debet)}}</td>
                <td>Rp. {{number_format($kredit)}}</td>
               
              </tr>
              <tr style="font-weight: bold;font-size:12;">
                <td>{{terbilang($debet)}} Rupiah</td>
                <td>{{terbilang($kredit)}} Rupiah</td>

              </tr>
            </tbody>
              
          </table>
        </div>

    </div>

  </div>
  

  
@endsection
@section('script')
<script type="text/javascript">
  $(document).ready(function(){
		$('#tombol').click(function(){
			$('.inputjurnal').fadeToggle(100);
		});
	});
	$('#datajurnal').DataTable({
  lengthChange: true,
  paging      : true,
  searching   : false,
  ordering    : true,
  autoWidth   : false,
  processing  : true,
  info        : true,
  serverSide  : true,
  ajax: '{{url('/keuangan/list-detail-akun/'.$id.'/'.$akun)}}',
  columns: [
      {data: 'tanggal', name: 'tanggal'},
      {data: 'nama_akun', name: 'nama_akun'},
      {data: 'kode_keuangan', name: 'kode_keuangan'},
      {data: 'keterangan', name: 'keterangan'},
      {data: 'debet', name: 'debet'},
      {data: 'kredit', name: 'kredit'},
     
    ]
  })
  
  $('#saveItem').on('click', function () {
    $.ajax({
      type: 'POST',
      url: '{{url('/keuangan/store-jurnal')}}',
      data: $('#simpanjurnal').serialize(),
      success: function (data) {
        console.log(data);
        if(data.sukses == false) {
          if(data.message!="") {
            alert(data.message)
          }else{
          }
        }else if(data.sukses == true){
          table.ajax.reload();
          $('#datatotal').ajax.reload();
          $('.inputjurnal').fadeOut(100);
          $('#groupTanggalTransaksiBarang').removeClass('has-error');
          $('#Tanggal_Transaksi-error').html( "" )
          $('#groupNoBukti').removeClass('has-error');
          $('#no_bukti-error').html( "" )
          $('#groupKodeKeuangan').removeClass('has-error');
          $('#kode_keuangan-error').html( "" )
          $('#groupNilai').removeClass('has-error');
          $('#nilai-error').html( "" )
          $('#groupKeterangan').removeClass('has-error');
          $('#keterangan-error').html( "" )
          $('#groupBalance').removeClass('has-error');
          $('#balance-error').html( "" )
          $('input[name="id"]').val("");
          $('input[name="no_bukti"]').val("");
          $('input[name="tanggal_transaksi"]').val("");
          $('input[name="kode_keuangan"]').val("");
          $('input[name="nilai"]').val("");
          $('input[name="keterangan"]').val("");
          $('input[name="balance"]').val("");
        }
      }
    });
  });
  $(document).ready(function(){
      $('.periode').datepicker({
          format: "MM-yyyy",
          viewMode: "months", 
          minViewMode: "months"
      });
    });
 
</script>
@endsection
