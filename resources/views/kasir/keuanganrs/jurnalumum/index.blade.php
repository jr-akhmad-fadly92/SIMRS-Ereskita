
@extends('master')
<style>
.inputjurnal{
	height: 300px;
	width:300px;
	display: none;
}
</style>
@section('head')

@endsection
@section('header')

  <h1>Jurnal Umum</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      Data Jurnal Umum&nbsp;
      </h3><a href="{{url('kasir/keuangan')}}" class="btn btn-success btn-flat">Back</a><hr>
      <div class="col-md-12">
          <form method="post" action="{{url('/keuangan/jurnal-umum')}}">
          {{ csrf_field() }} {{ method_field('POST') }}
          <div class="col-md-12">
            <div class="form-group">

              {!! Form::label('periode', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}

              <div class="col-sm-6">

                {!! Form::text('periode', null, ['class' => 'form-control periode tampil']) !!}

                  <small class="text-danger">{{ $errors->first('periode') }}</small>

              </div>

              <div class="col-sm-3">

                  <input type="submit" class="btn btn-success btn-flat" id="saveItem" value="Cari">

                  <small class="text-danger">{{ $errors->first('tgb') }}</small>

              </div>

            </div>
            
          </div>
          </form>

      </div>
    </div>
    <div class="box-body">
    
        <div class='table-responsive col-md-12'>
          <table class='table table-striped table-bordered table-hover table-condensed text-center' id="data">
          
            <thead>
              <tr>
                <th style="width:10%;">No</th>
                <th>Waktu</th>
                <th>Pilih</th>
              </tr>
            </thead>
            <tbody>
            @foreach($no_jurnal as $data)
              <tr>
                <td>{{$no++}}</td>
                <td>{{date('F Y', strtotime($data->tanggal_transaksi))}}</td>
                <td><a href="{{url('/keuangan/jurnal-umum/'.$data->no_jurnal)}}" class="btn btn-info btn-flat btn-sm" style="font-weight:bold;"><i class="fa fa-check"></i>&nbsp Detail</a></td>
              </tr>
              @endforeach
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
  ajax: '{{url('/keuangan/list-jurnal-bulan-ini')}}',
  columns: [
      {data: 'tanggal', name: 'tanggal'},
      {data: 'nama_akun', name: 'nama_akun'},
      {data: 'kode_keuangan', name: 'kode_keuangan'},
      {data: 'keterangan', name: 'keterangan'},
      {data: 'debet', name: 'debet'},
      {data: 'kredit', name: 'kredit'},
      {data: 'hapus'},
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
