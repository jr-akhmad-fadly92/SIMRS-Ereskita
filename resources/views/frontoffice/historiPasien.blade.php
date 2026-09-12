@extends('master')
@section('header')
  <h1>Histori Pasien <small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
      <div class="row">
      <div class="col-md-3">
          {!! Form::open(['method' => 'POST', 'url' => 'frontoffice/histori-pasien', 'class'=>'form-hosizontal']) !!}
            <div class="input-group{{ $errors->has('no_rm') ? ' has-error' : '' }}">
                <span class="input-group-btn">
                  <button class="btn btn-default{{ $errors->has('no_rm') ? ' has-error' : '' }}" type="button">Nomor RM</button>
                </span>
                {!! Form::text('no_rm', null, ['class' => 'form-control', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('no_rm') }}</small>
            </div>
         {!! Form::close() !!}

        </div>
        <div class="col-md-12">
          <div class="table-responsive">
            <table class="table table-condensed table-bordered table-hover">
              <tbody>
                <tr>
                  <th colspan="1">Nomor RM Baru</th><td colspan="3"><b>{{ !empty($pasien) ?$pasien->no_rm :NULL }}</b></td>
                </tr>
                <tr>
                  <th colspan="4">Nama Lengkap &nbsp&nbsp: {{ !empty($pasien) ? $pasien->nama :NULL }}&nbsp &nbsp&nbsp/&nbsp&nbsp Nama Ibu  &nbsp&nbsp: {{ !empty($pasien) ? $pasien->ibu_kandung :NULL }}</td>
                </tr>
                <tr >
                  <th >No KTP</th><td>{{ !empty($pasien) ? $pasien->nik : NULL }} </td><th >Tanggal Lahir / Umur Pasien</th><td>{{ tgl_indo($pasien->tgllahir) }} / {{ hitung_umur($pasien->tgllahir,'Y') }}</td>
                </tr>
                <tr >
                  <th >Agama</th><td>{{ !empty($pasien) ? $pasien->agama_id : NULL ? Modules\Pasien\Entities\Agama::find($pasien->agama_id)->agama : NULL }} </td><th >Pendidikan</th><td>{{ !empty($pasien) ? $pasien->pendidikan_id : NULL?Modules\Pendidikan\Entities\Pendidikan::find($pasien->pendidikan_id)->pendidikan : NULL }}</td>
                </tr>
                <tr >
                  <th >status</th><td>{{ !empty($pasien) ? $pasien->status_marital : NULL }} </td><th >Jenis Kelamin</th><td>{{ !empty($pasien) ? $pasien->kelamin : NULL }}</td>
                </tr>
                <tr>
                  <th>Alamat</th><td colspan="3">{{ !empty($pasien) ? $pasien->alamat : NULL }} rt: {{ !empty($pasien) ? $pasien->rt : NULL }} rw: {{ !empty($pasien) ? $pasien->rw : NULL }}</td>
                </tr>
                <tr>
                  <th>No Telp</th><td>{{ !empty($pasien) ? $pasien->notlp : NULL }} / {{ !empty($pasien) ? $pasien->nohp : NULL }}</td>
                </tr>

              </tbody>
            </table>
          </div>
        </div>
        
      </div>


    <div class="table-responsive">
      <table class="table table-condensed table-bordered table-hover">
        <thead>
          <tr style="background-color: #bde9ba;" >
            <th rowspan="2" class="text-center" style="vertical-align: middle;">No</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Tanggal Registrasi</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Klinik</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Riwayat Penyakit / Pemeriksaan</th>
            <th colspan="6" class="text-center">Hasil Pemeriksanaan</th>
            <th rowspan="2" class="text-center" style="vertical-align: middle;">Status</th>
          </tr>
          <tr style="background-color: #bde9ba;">
            <th class="text-center">Diagnosa</th>
            <th class="text-center">Resep Obat</th>
            <th class="text-center">Dokter</th>
            <th class="text-center">Keadaan Keluar</th>
            <th class="text-center">Lab</th>
            <th class="text-center">Rad</th>
          </tr>
        </thead>
        <tbody>
          @if (!empty($reg))
            @foreach ($reg as $d)
              @php
                $rj = App\HistorikunjunganIRJ::where('registrasi_id', $d->id)->first();
                $lab = App\HistorikunjunganLAB::where('registrasi_id', $d->id)->get();
                $rad = App\HistorikunjunganRAD::where('registrasi_id', $d->id)->get();
                $ri = App\Rawatinap::where('registrasi_id', $d->id)->first();
                
                
              @endphp
              <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $d->created_at->format('d-m-Y H:i:s') }}</td>
                <td>{{ baca_poli($d->poli_id) }}</td>
                <td>
                {{ !empty($d) ? $d->diagnosa_akhir : NULL }},<br>
                <br>
                </td>
                <td>
                
                @foreach(Modules\Icd9\Entities\Icd9::all() as $ic9)
                @foreach(App\PerawatanIcd9::where('registrasi_id',$d->id)->get() as $ic)
                @if($ic->icd9 == $ic9->nomor)
                {{ $ic9->nama }} , 
                @endif
                @endforeach
                @endforeach

                </td>
                <td>
                @foreach(App\Masterobat::all() as $mo)
                @foreach(App\Penjualan::where('registrasi_id',$d->id)->get() as $pj)
                @foreach(App\Penjualandetail::where('masterobat_id',$mo->id)->where('penjualan_id',$pj->id)->get() as $ic)
                
                {{ $mo->nama }}
                @endforeach
                @endforeach
                @endforeach


                </td>
                <td>
                {{ !empty($d) ? baca_dokter($d->dokter_id) : NULL }}
                </td>
                <td>
                {{ !empty($d) ? $d->keadaan_keluar_inap : NULL }}
                </td>
                <td>
                @foreach($hasil_lab as $data)
                @if($data->registrasi_id==$d->id)
                <a href="{{url('pemeriksaanlab/cetakpasien/'.$d->id)}}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-search"></i></a>
                @else
                
                @endif
                
                @endforeach
                </td>
                <td>
                @foreach($hasil_rad as $data)
                @if($data->registrasi_id==$d->id)
                <a href="{{url('radiologi/q/'.$d->id)}}" class="btn btn-sm btn-info btn-flat"><i class="fa fa-search"></i></a>
                @else
                
                @endif
                
                @endforeach
                </td>
                  <td class="text-left">
										<span class="text-left" >
                    @if ( substr($d->status_reg,0,1) == 'J' )
                      RAWAT JALAN
                    @elseif ( substr($d->status_reg,0,1) == 'G' )
                      RAWAT DARURAT
                    @elseif ( $d->status_reg == 'I2' )
                      RAWAT INAP
                    @elseif ($d->status_reg == 'I3')
                      SUDAH PULANG
                    @endif
										</span>
										@role('supervisor')
											<button class="btn btn bg-default btn-flat" onclick="ubahPelayanan({{ $d->id }})"><i class="fa fa-edit"></i> </button>
											@if($d->pulang==null)
												<a target="_blank" class="btn btn bg-primary btn-flat" href="{{ url('/tindakan/entry/'.$d->id.'/'.$d->pasien_id) }}"><i class="fa fa-check"></i> Proses</a>
											@endif
										@endrole
                  </td>
              </tr>
            @endforeach
          @else
            <tr>
              <th colspan="8" class="text-center"><h4>Data tidak ditemukan!!!</h4></th>
            </tr>
          @endif
        </tbody>
      </table>
    </div>


    <div class="box-footer">
    </div>
  </div>

  {{-- MODAL UBAH STATUS PELAYANAN --}}
  <div class="modal fade" id="pelayanan">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <h4 style="font-size: 12pt; font-weight: bold;">Status : <span class="status"></span></h4>
          {!! Form::open(['method' => 'POST', 'class'=>'form-horizontal', 'id' => 'formStatus']) !!}
            <input type="hidden" name="registrasi_id" value="">
            <div class="form-group">
              <label for="status" class="col-md-4 control-label">Kembalikan Status Ke</label>
              <div class="col-lg-8">
                <select name="status_reg" class="form-control">
                  <option value="">--</option>
                  <option value="J2">RAWAT JALAN</option>
                  <option value="G2">RAWAT DARURAT</option>
                  <option value="I2">RAWAT INAP</option>
                  <option value="menunggu persalinan">MENUNGGU PERSALINAN</option>
                </select>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
        <div class="modal-footer">
          <div class="btn-group">
            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Batal</button>
            <button type="button" class="btn btn-primary btn-flat" onclick="simpanStatus()">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('script')
  <script type="text/javascript">
    function ubahPelayanan(registrasi_id) {
      $('#pelayanan').modal('show');
      $('.modal-title').text('Ubah Status Pelayanan');
      $.ajax({
        url: '/get-data-registrasi/'+registrasi_id,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
          $('.status').html(data.status_reg)
          $('input[name="registrasi_id"]').val(data.registrasi_id)
        }
      });
    }

    function simpanStatus() {
      $.ajax({
        url: '/ubah-status-pelayanan',
        type: 'POST',
        dataType: 'json',
        data: $('#formStatus').serialize(),
        success: function (data) {
          if (data.sukses == true) {
						location.reload();
          }else{
						alert('Gagal mengubah status');
					}
        }
      });
      
    }
  </script>
@endsection
