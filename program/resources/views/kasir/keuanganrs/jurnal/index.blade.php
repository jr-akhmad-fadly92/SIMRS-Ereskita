
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

  <h1>Input Jurnal</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">
      Input Jurnal&nbsp;
      </h3><hr>
      
	    <button id="tombol" class="btn btn-success">Input Jurnal</button>
      &nbsp<a href="{{url('kasir/keuangan')}}" class="btn btn-success">Back</a>
      <div class="inputjurnal col-md-12">
          <form  id="simpanjurnal">
          {{ csrf_field() }} {{ method_field('POST') }}
          <br>
          <div class="col-md-12">
            <div class="form-group">
              {!! Form::label('tanggal_transaksi', 'Tanggal Transaksi', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-3">
                  {!! Form::text('tanggal_transaksi', null, ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('tanggal_transaksi') }}</small>
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('no_bukti', 'No Bukti Transaksi', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-3">
                  {!! Form::text('no_bukti', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('no_bukti') }}</small>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              {!! Form::label('kode_keuangan', 'Akun', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-3">
                  <select name="kode_keuangan" class="form-control " id="kode_keuangan">
                    
                    @foreach(App\AkunKeuangan::all() as $data)
                    <option value="{{$data->kode_keuangan}}">{{$data->nama_akun}}</option>
                    @endforeach
                  </select>
                  <small class="text-danger">{{ $errors->first('kode_keuangan') }}</small>
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('balance', 'Balance', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-3">
                  <select name="balance" class="form-control " id="balance">
                    <option value="D">Debet</option>
                    <option value="K">Kredit</option>
                  </select>
                  <small class="text-danger">{{ $errors->first('balance') }}</small>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              {!! Form::label('nilai', 'Nominal', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-3">
                  {!! Form::number('nilai', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('nilai') }}</small>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              {!! Form::label('keterangan', 'Keterangan', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-12" >
                  <textarea name="keterangan" id="keterangan" class="form-control"></textarea><br>
                  <small class="text-danger">{{ $errors->first('keterangan') }}</small>
              </div>
            </div>
          </div>
          
            <div class="form-group">
              <input type="submit" class="btn btn-success" id="saveItem" value="Simpan">
            </div>
          </form>

      </div>
    </div>
    <div class="box-body">
    
        <div class='table-responsive col-md-12'>
        <h4>Data Jurnal Umum Bulan {{ $bulan }}</h4>
          <table class='table table-striped table-bordered table-hover table-condensed' id="datajurnal">
          
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Nama Akun</th>
                <th>Kode</th>
                <th>Keterangan</th>
                <th>Debet</th>
                <th>Kredit</th>
                <th>Aksi</th>
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
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <tr style="font-weight: bold;font-size:12;">
                <td>Rp. {{number_format($debet)}}</td>
                <td>Rp. {{number_format($kredit)}}</td>
                @if($debet==$kredit)
                <td rowspan=2 class="text-center alert alert-success">
                BALANCE
                </td>
                @else
                <td rowspan=2 class="text-center alert alert-danger">
                FRAUD
                </td>
                @endif
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

 
</script>
@endsection
