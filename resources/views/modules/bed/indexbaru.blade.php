

@extends('master')

@section('header')
  <h1>Master Bed Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Bed &nbsp;
					
        </h3>
        <br><br>
        {!! Form::open(['method' => 'POST','id'=>'bed', 'url' => '/bed', 'class' => 'form-horizontal']) !!}

        <div class="row">
          <div class="col-md-6">
          <div class="form-group">
                {!! Form::label('kamar', 'Kamar', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-8">
                    <select class="form-control select2" id="kamar" name="kamar">
                    <option value="">-- semua --</option>
                    @foreach($kamar as $data)
                      @if (!empty($_POST['kamar']) && $_POST['kamar'] == $data->id)
                        <option value="{{ $data->id }}" selected>{{ $data->nama }}</option>
                      @else
                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                      @endif
                    @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('petugas') }}</small>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('kelas', 'Kelas', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-8">
                    <select class="form-control select2" id="kelas" name="kelas">
                    <option value="">-- semua --</option>
                    @foreach($kelas as $data)
                      @if (!empty($_POST['kelas']) && $_POST['kelas'] == $data->id)
                        <option value="{{ $data->id }}" selected>{{ $data->nama }}</option>
                      @else
                        <option value="{{ $data->id }}">{{ $data->nama }}</option>
                      @endif
                    
                    @endforeach
                    </select>
                    <small class="text-danger">{{ $errors->first('kelas') }}</small>
                </div>
            </div>
            
          </div>
          <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('tipe_layanan', 'Tipe Layanan', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-8">
                {!! Form::select('status', [null=>'Semua','Y'=>'Isi Pasien', 'AP'=>'Akan Pulang', 'N'=>'Kosong'], null, ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('tipelayanan') }}</small>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('', '', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                  <div class="btn-group ">
                      <input type="submit" name="lanjut" class="btn btn-primary btn-flat" value="LANJUT">
                  </div>
                </div>
            </div>

          </div>
        </div>

        {!! Form::close() !!}
        
      </div>
      <div class="box-body">
      <div class="card-body p-0" style="display: block;">
                    <ul class="users-list clearfix">
                    @foreach($bed as $data)
                    @php 
                    $data_rawat = App\Rawatinap::join('registrasis','registrasis.id','=','rawatinaps.registrasi_id')->join('pasiens','pasiens.id','=','registrasis.pasien_id')->whereIn('registrasis.posisi_pasien',['sedang diperiksa','menunggu persalinan','rawat inap','Konfirmasi Farmasi'])->where('rawatinaps.bed_id',$data->bed_id)->select('pasiens.nama as nama_pasien','rawatinaps.registrasi_id','registrasis.*')->first();
                    @endphp
                      <li>
                      @if($data_rawat==null)
                      <a class="view" data-nama="kosong" data-dokter="kosong" data-bangsal="{{$data->nama_kamar}}" data-bed="{{$data->nama_bed}}" href="#">
                        <img src="{{ asset('laravel/menu/bed.png') }}" alt="User Image" width="50px" heigth="50px"></a>
                        <a class="users-list-name view" data-nama="kosong" data-dokter="kosong" data-bangsal="{{$data->nama_kamar}}" data-bed="{{$data->nama_bed}}" href="#">{{$data->nama_kamar}} / {{$data->nama_bed}} </a>
                        @if($data->reserved=='Y')
                        <span class="btn badge badge-primary " >Rawat Inap</span>
                        @elseif($data->reserved=='AP')
                        <span class="btn badge badge-warning " >Akan Pulang</span>
                        @elseif($data->reserved=='N')
                        <span class="btn badge badge-secondary " >Kosong</span>
                        @endif
                      </li>
                      @else
                      <a class="view" data-nama="{{$data_rawat->nama_pasien}}" data-dokter="{{baca_dokter($data_rawat->dokter_id)}}" data-bangsal="{{$data->nama_kamar}}" data-bed="{{$data->nama_bed}}" href="#">
                        <img src="{{ asset('laravel/menu/bed.png') }}" alt="User Image" width="50px" heigth="50px"></a>
                        <a class="users-list-name view" data-nama="{{$data_rawat->nama_pasien}}" data-dokter="{{baca_dokter($data_rawat->dokter_id)}}" data-bangsal="{{$data->nama_kamar}}" data-bed="{{$data->nama_bed}}" href="#">{{$data->nama_kamar}} / {{$data->nama_bed}} </a>
                        
                        <a class="users-list-name view" data-nama="{{$data_rawat->nama_pasien}}" data-dokter="{{baca_dokter($data_rawat->dokter_id)}}" data-bangsal="{{$data->nama_kamar}}" data-bed="{{$data->nama_bed}}" href="#" >{{$data_rawat->nama_pasien}} </a>
                       
                        @if($data->reserved=='Y')
                        <span class="btn badge badge-primary " >Rawat Inap</span>
                        @elseif($data->reserved=='AP')
                        <span class="btn badge badge-warning " >Akan Pulang</span>
                        @elseif($data->reserved=='N')
                        <span class="btn badge badge-secondary " >Kosong</span>
                        @endif
                      </li>
                      @endif
                      
                    @endforeach
                    </ul>
                    <!-- /.users-list -->
                    <!-- Modal Detail Bed-->
                    <div class="modal fade" id="detail_bed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span> 
                            </button><h4 class="modal-title" id=""></h4>
                          </div>
                          <div class="modal-body">
                        
                        
                          <table class='table table-striped table-bordered table-hover table-condensed'>
                              <tbody>
                                <tr>
                                    <th>Nama Pasien</th> <td ><input id="nama" name="nama" class="form-control" readonly></td>
                                </tr>
                                <tr>
                                    <th>Nama Dokter</th> <td><input id="dokter" name="dokter" class="form-control" readonly>  </td>
                                </tr>
                                <tr>
                                    <th>Bangsal</th> <td ><input id="bangsal" name="bangsal" class="form-control" readonly>  </td>
                                </tr>
                                <tr>
                                    <th>Bed</th> <td ><input id="bed" name="bed" class="form-control" readonly>  </td>
                                </tr>
                              </tbody>
                          </table>
                          
                          
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            
                          </div>
                        </div>
                      </div>
                    </div>
      </div>
      </div>
    </div>
    @section('script')
    <script type="text/javascript">
    
    //DETAIL BED
    $(document).on('click', '.view',function () {
        $('#detail_bed').modal('show');
        $('.modal-title').text('Detail BED');
        $('input[name="nama"]').val($(this).attr('data-nama'));
        $('input[name="dokter"]').val($(this).attr('data-dokter'));
        $('input[name="bangsal"]').val($(this).attr('data-bangsal'));
        $('input[name="bed"]').val($(this).attr('data-bed'));
    });

       
    </script>
@endsection
@stop
