@extends('master')
@section('header')
  <h1>Laporan Stok Gudang</h1>
@endsection

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
    <h4>Laporan Stok Gudang</h4>
    </div>
    <div class="box-body">
    {!! Form::open(['method' => 'POST','id'=>'laporanTagihan', 'url' => '/laporan/stok_gudang', 'class' => 'form-horizontal']) !!}

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
      @isset($Laporan_stok)
      <center><b>LAPORAN STOK GUDANG </b><br>
      Periode : {{$periode}}
      </center>
        <div class='table-responsive'>
        @if($kategori=='obat')
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr class="info">
              
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;">Kode Obat</th>
                <th style="vertical-align: middle;">No Batch</th>
                <th style="vertical-align: middle;">Nama Obat</th>
                <th style="vertical-align: middle;">stok</th>
                <th style="vertical-align: middle;">Harga Satuan</th>
                <th style="vertical-align: middle;">Nilai Persediaan</th>
              
              </tr>
            </thead>
            <tbody>
              @foreach($Laporan_stok as $data)
              <tr>
                <td>{{$no++}}</td>
                <td>{{$data->kode_obat}}</td>
                <td>{{$data->no_batch}}</td>
                <td>{{$data->nama_obj}}</td>
                <td>{{$data->stok}}</td>
                <td>Rp.{{number_format($data->harga)}}</td>
                <td>Rp.{{number_format($data->nilai_persediaan)}}</td>
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
          Total Item : {{number_format($item_stok)}} item<br>
          Total Jumlah Barang Di terima : {{number_format($jumlah_stok)}} barang<br>
          Total Biaya Pemesanan : Rp. {{number_format($biaya_stok->nilai_persediaan)}}
        @elseif($kategori=='inventaris')
          <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr class="info">
              
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;">Nama Barang</th>
                <th style="vertical-align: middle;">Supplier</th>
                <th style="vertical-align: middle;">stok</th>
                <th style="vertical-align: middle;">Harga Satuan</th>
                <th style="vertical-align: middle;">Nilai Persediaan</th>
              
              </tr>
            </thead>
            <tbody>
              @foreach($Laporan_stok as $data)
              <tr>
                <td>{{$no++}}</td>
                <td>{{$data->nama_barang}}</td>
                <td>{{$data->nama_produsen}}</td>
                <td>{{$data->stok}}</td>
                <td>Rp.{{number_format($data->harga_unit)}}</td>
                <td>Rp.{{number_format($data->total_harga)}}</td>
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
          Total Harga : 
          @php
          $harga_total = 0;
          
          foreach($Laporan_stok as $item=>$value)
          {
          $harga_total +=$value->total_harga;
          }
          
          @endphp
          Rp. {{number_format($harga_total)}}
          <br>
          Total Barang : 
          @php
          $stok = 0;
          
          foreach($Laporan_stok as $item=>$value)
          {
          $stok +=$value->stok;
          }
          
          @endphp
          {{$stok}} Barang
          <br>
        @else
        <table class='table table-striped table-bordered table-hover table-condensed' id="data">
            <thead>
              <tr class="info">
              
                <th style="vertical-align: middle;">#</th>
                <th style="vertical-align: middle;">Kode t</th>
                <th style="vertical-align: middle;">Nama</th>
                <th style="vertical-align: middle;">Satuan</th>
                <th style="vertical-align: middle;">Jenis</th>
                <th style="vertical-align: middle;">stok</th>
                <th style="vertical-align: middle;">Harga Satuan</th>
                <th style="vertical-align: middle;">Nilai Persediaan</th>
              
              </tr>
            </thead>
            <tbody>
              @foreach($Laporan_stok as $data)
              <tr>
                <td>{{$no++}}</td>
                <td>{{$data->kode_barang}}</td>
                <td>{{$data->nama_barang}}</td>
                <td>{{$data->satuan}}</td>
                <td>{{$data->jenis_barang}}</td>
                <td>{{$data->stok}}</td>
                <td>Rp.{{number_format($data->harga)}}</td>
                <td>Rp.{{number_format($data->total_harga)}}</td>
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
          Total Item : {{number_format($item_stok)}} item<br>
          Total Jumlah Barang Di terima : {{number_format($jumlah_stok)}} barang<br>
          Total Biaya Pemesanan : Rp. {{number_format($biaya_stok->nilai_persediaan)}}
        
        @endif  
        </div>

  
  
      @endisset



    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
