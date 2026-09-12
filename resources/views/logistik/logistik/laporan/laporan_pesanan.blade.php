@extends('master')
@section('header')
  <h1>Laporan Pemesanan Barang</h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
    <h4>Laporan Pesanan Barang</h4>
    </div>
    <div class="box-body">
    {!! Form::open(['method' => 'POST','id'=>'laporanTagihan', 'url' => '/laporan/pemesanan', 'class' => 'form-horizontal']) !!}

      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
              {!! Form::label('tga', 'Tanggal', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-4">
                  {!! Form::text('tga', null, ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('tga') }}</small>
              </div>
              <div class="col-sm-4">
                  {!! Form::text('tgb', null, ['class' => 'form-control datepicker']) !!}
                  <small class="text-danger">{{ $errors->first('tgb') }}</small>
              </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
              {!! Form::label('po_kategori_order', 'Kategori', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                  <select class="form-control" name="po_kategori_order">
                              @if($kategori=='obat')<option value="obat" selected>Obat</option>@else<option value="obat">Obat</option>@endif
                              @if($kategori=='inventaris')<option value="inventaris" selected>Inventaris</option>@else<option value="inventaris">Inventaris</option>@endif
                              @if($kategori=='nonmedis')<option value="nonmedis" selected>Non-Medis</option>@else<option value="nonmedis">Non-Medis</option>@endif
                             
                  </select>
                  <small class="text-danger">{{ $errors->first('po_kategori_order') }}</small>
              </div>
          </div>
          <br>
          <div class="form-group">
              {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
                <div class="btn-group ">
                    <input type="submit" name="lanjut" class="btn btn-primary btn-flat fa fa-file" value="LANJUT">
                    <input type="submit" name="pdf" class="btn btn-danger btn-flat fa fa-file-pdf-o" value="&#xf1c1; CETAK">
                </div>
              </div>
          </div>

        </div>
      </div>
      
      {!! Form::close() !!}

      <hr>
      @isset($Laporan_pemesanan)
      <center><b>LAPORAN PESANAN </b><br>
      Periode : {{$periode}}
      </center>
      <br>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed'>
            <thead>
              <tr class="info">
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;">PO</th>
                <th style="vertical-align: middle;">Faktur</th>
                <th style="vertical-align: middle;">Kode</th>
                <th style="vertical-align: middle;">Nama</th>
                <th style="vertical-align: middle;">Satuan</th>
                <th style="vertical-align: middle;">Jumlah</th>
                <th style="vertical-align: middle;">Jumlah Diterima</th>
                <th style="vertical-align: middle;">Harga Satuan</th>
                <th style="vertical-align: middle;">Harga Total</th>
                <th style="vertical-align: middle;">Status</th>
                
              </tr>
            </thead>
            <tbody>

            @foreach($Laporan_pemesanan as $data)
            <tr>
              <td>{{$no++}}</td>
              <td>{{$data->no_po}}</td>
              <td>{{$data->no_faktur}}</td>
              <td>{{$data->kode}}</td>
              <td>{{$data->nama_obj}}</td>
              <td>{{$data->dpo_item_unit}}</td>
              <td>{{$data->jumlah}}</td>
              <td>{{$data->jumlah_diterima}}</td>
              <td>Rp. {{number_format($data->dpo_price)}}</td>
              <td>Rp. {{number_format($data->total_biaya)}}</td>
              <td>{{$data->po_status}}</td>
            </tr>  
            @endforeach
            </tbody>
            <tfoot>
              <tr>
              
              </tr>
              <tr>
               
              </tr>

              <tr>
              
              </tr>
            </tfoot>
          </table>
          Total Item : {{$item_pemesanan}} item<br>
          Total Jumlah Barang Di terima : {{$jumlah_pemesanan}} barang<br>
          Total Nilai Pemesanan : Rp. {{number_format($biaya_pemesanan->total_biaya)}}
        </div>
  
  
      @endisset



    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
