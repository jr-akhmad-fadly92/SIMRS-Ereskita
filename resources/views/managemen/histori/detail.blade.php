@extends('master')
@section('header')
  <h1>Pegawai Rumah Sakit</h1>
@endsection
@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Detail Histori Pendidikan dan Kesehatan &nbsp;&nbsp; <a href="{{url('/managemen/histori-pegawai')}}"class="btn btn-sm btn-flat btn-primary">Back</a><br> &nbsp;
        </h3>
        <table class='table table-striped ' >
          <thead>
            <tr>
                <th>Nip</th>
                <th>: {{$pegawai->kode}}</th>
                <th>Nama</th>
                <th>: {{$pegawai->nama}}</th>
            </tr>
            <tr>
                <th>Status Pegawai</th>
                <th>: {{$pegawai->keterangan}}</th>
                <th>jabatan</th>
                <th>: {{$pegawai->kategori}}</th>
            </tr>
            
            </thead>
           <tbody>
           </tbody>
          </table>
      </div>
      <div class="box-body">
        
        <div class='table-responsive'>
          <h4>Histori Pendidikan &nbsp&nbsp
          <button class="btn btn-sm btn-info btn-flat insert" data-toggle="modal" data-target="#pendidikan" data-id="" data-institut="" data-masuk="" data-keluar=""
          data-keterangan="" data-pendidikan="1"><i class="fa fa-plus-circle"></i> Tambah</button></h4> 
          <table class='table table-striped table-bordered table-hover table-condensed dataPendidikan' id="histori">
          <thead>
              <tr>
                <th>No</th>
                <th>Pendidikan</th>
                <th>Institut</th>
                <th>Masuk</th>
                <th>Selesai</th>
                <th style="width:50px;">detail</th>
              </tr>
            </thead>
            <tbody>
              @foreach($histori_pendidikan as $data)
              <tr>
                <td>{{$no++}}</td>
                <td>{{$data->pendidikan}}</td>
                <td>{{$data->institut}}</td>
                <td>{{tanggalkuitansi(valid_date($data->masuk_pendidikan))}}</td>
                <td>{{tanggalkuitansi(valid_date($data->keluar_pendidikan))}}</td>
                <td><button data-id="{{$data->id}}"  data-nama="{{$data->institut}}" data-masuk="{{$data->masuk_pendidikan}}" data-keluar="{{$data->keluar_pendidikan}}" data-pendidikan="{{$data->pendidikan_id}}" data-keterangan="{{$data->keterangan}}" class="btn btn-sm btn-success btn-flat insert"><i class="fa fa-search"></i></button></td>
                
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class='table-responsive'>
          <h4>Histori Kesehatan &nbsp&nbsp<button class="btn btn-sm btn-info btn-flat insert_kesehatan" data-toggle="modal" data-target="#kesehatan" data-id="" data-riwayat_penyakit="" data-masuk="" data-opnam="tidak"
          ><i class="fa fa-plus-circle"></i> Tambah</button></h4>
          <table class='table table-striped table-bordered table-hover table-condensed table-pegawai' id="histori_kesehatan">
          <thead>
              <tr>
                <th>No</th>
                <th>Riwayat Penyakit</th>
                <th>Status ( opnam / tidak )</th>
                <th>Masuk Opnam</th>
                <th>detail</th>
              </tr>
            </thead>
           <tbody>
            @foreach($histori_kesehatan as $data)
            <tr>
                <th>{{$no++}}</th>
                <th>{{$data->riwayat_penyakit}}</th>
                <th>{{$data->opnam}}</th>
                <th>{{tanggalkuitansi(valid_date($data->masuk_opnam))}}</th>
                <th><button data-id="{{$data->id}}" data-riwayat_penyakit="{{$data->riwayat_penyakit}}" data-masuk="{{$data->masuk_opnam}}" data-opnam="{{$data->opnam}}" class="btn btn-sm btn-success btn-flat insert_kesehatan"><i class="fa fa-search"></i></button></th>
              </tr>
            @endforeach
           </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pendidikan" tabindex="-1" role="dialog" style=" padding-right: 17px;"aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title">Input / Edit Histori Pendidikan
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              </h4>
          </div>
          <div class="modal-body">
          
          <form method="post" action="{{url('managemen/input-pendidikan')}}">
            {{ csrf_field() }}
            <input type="hidden" name="id" class="form-control " value="">
            <input type="hidden" name="pegawai_id" class="form-control " value="{{$pegawai->id}}">
            <div class="form-group">
                <label>Pendidikan</label>
                <select class="form-control" name="pendidikan_id" id="pendidikan_id">
                  @foreach ($pendidikan as $data)
                      <option value="{{ $data->id }}">{{ $data->pendidikan }}</option>
                  @endforeach
                </select>

            </div>
            <div class="form-group">
                <label>Nama Institut / jurusan </label>
                <input type="text" name="institut" class="form-control" value="" placeholder="contoh : ATEM Semarang / Elektromedik">
            </div>
            <div class="form-group">
                <label>Masuk Pendidikan</label>
                <input type="date" name="masuk_pendidikan"  value="" style="border: 2px solid #e9e9e9; height:30px;" >&nbsp&nbsp&nbsp&nbsp
                <label>Selesai Pendidikan </label>
                <input type="date" name="keluar_pendidikan"  value="" placeholder="contoh : ATEM Semarang / Elektromedik" style="border: 2px solid #e9e9e9; height:30px;">
            </div>
            <div class="form-group">
                <label>Keterangan</label><br>
                <textarea name="keterangan" class="form-control" style="width:100%;height:60px;" ></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="kesehatan" tabindex="-1" role="dialog" style=" padding-right: 17px;"aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
          <h4 class="modal-title">Input / Edit Histori Kesehatan
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              </h4>
          </div>
          <div class="modal-body">
          
          <form method="post" action="{{url('managemen/input-kesehatan')}}">
            {{ csrf_field() }}
            <input type="hidden" name="id" class="form-control " value="">
            <input type="hidden" name="pegawai_id" class="form-control " value="{{$pegawai->id}}">
            <div class="form-group">
                <label>Riwayat Penyakit</label>
                <input type="text" name="riwayat_penyakit" class="form-control" value="" placeholder="contoh : Jantung">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="opnam" id="opnam">
                      <option value="opnam">Opnam</option>
                      <option value="tidak">Tidak</option>
                </select>
            </div>
            <div class="form-group">
                <label>Masuk Opnam</label>
                <input type="date" name="masuk_opnam"  value="" style="border: 2px solid #e9e9e9; height:30px;" >&nbsp&nbsp&nbsp&nbsp
            </div>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
@stop
@section('script')
<script type="text/javascript">
    $(document).on('click', '.insert',function () {
    $('input[name="id"]').val($(this).attr('data-id'));
    $('input[name="institut"]').val($(this).attr('data-nama'));
    $('input[name="masuk_pendidikan"]').val($(this).attr('data-masuk'));
    $('input[name="keluar_pendidikan"]').val($(this).attr('data-keluar'));
    $('textarea[name="keterangan"]').val($(this).attr('data-keterangan'));
    $("#pendidikan_id" ).val($(this).attr('data-pendidikan')).prop('selected', true);
    $('#pendidikan').modal('show');

    });
    $(document).on('click', '.insert_kesehatan',function () {
    $('input[name="id"]').val($(this).attr('data-id'));
    $('input[name="riwayat_penyakit"]').val($(this).attr('data-riwayat_penyakit'));
    $('input[name="masuk_opnam"]').val($(this).attr('data-masuk'));
    $("#opnam" ).val($(this).attr('data-opnam')).prop('selected', true);
    $('#kesehatan').modal('show');

    });
    $(document).ready(function() {
    $('#histori').DataTable();
    } );
    $(document).ready(function() {
    $('#histori_kesehatan').DataTable();
    } );
   
</script>
@endsection
