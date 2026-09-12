<div class="form-group{{ $errors->has('no_inv') ? ' has-error' : '' }}">
    {!! Form::label('no_inv', 'No Inv', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
       
        {!! Form::text('no_inv', null, ['class' => 'form-control ','readonly']) !!}
     
        <small class="text-danger">{{ $errors->first('no_inv') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('asal_ruangan') ? ' has-error' : '' }}">
    {!! Form::label('asal_ruangan', 'Asal Ruangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
       
        <select class="form-control" name="asal_ruangan" readonly>
          
          @foreach (App\Masterruangan::all() as $d)
            @if ( $Inventarisdetail->ruangan == $d->id)
              <option value="{{ $Inventarisdetail->ruangan }}" selected >{{ $d->ruangan }}</option>
            @else
         
            @endif
          @endforeach
        </select>
     
        <small class="text-danger">{{ $errors->first('asal_ruangan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('update_ruangan') ? ' has-error' : '' }}">
    {!! Form::label('update_ruangan', 'Ruangan yang dituju', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
       
        <select class="form-control" name="update_ruangan">
          <option value="">====Pilih====</option>
          @foreach (App\Masterruangan::all() as $d)
            
              <option value="{{ $d->id }}">{{ $d->ruangan }}</option>
            
          @endforeach
        </select>
     
        <small class="text-danger">{{ $errors->first('update_ruangan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('tanggal_pindah') ? ' has-error' : '' }}">
    {!! Form::label('tanggal_pindah', 'Tanggal Pindah', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
    {!! Form::text('tanggal_pindah', (!empty($Inventarisdetail->tanggal_pindah)) ? tgl_indo($Inventarisdetail->tanggal_pindah) : null, ['class' => 'datepicker form-control', 'id'=>'tanggal_pindah']) !!}
        <small class="text-danger">{{ $errors->first('tanggal_pindah') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kondisi_barang') ? ' has-error' : '' }}">
    {!! Form::label('kondisi_barang', 'Kondisi Barang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
       
        <select class="form-control" name="kondisi_barang">

            @if($Inventarisdetail->kondisi_barang=='ada')<option value="ada" selected>Ada</option>@else<option value="ada">Ada</option>@endif
            @if($Inventarisdetail->kondisi_barang=='rusak')<option value="rusak" selected>Rusak</option>@else<option value="rusak">Rusak</option>@endif
            @if($Inventarisdetail->kondisi_barang=='hilang')<option value="hilang" selected>Hilang</option>@else<option value="hilang">Hilang</option>@endif
            @if($Inventarisdetail->kondisi_barang=='perbaikan')<option value="perbaikan" selected>Perbaikan</option>@else<option value="perbaikan">Perbaikan</option>@endif
            @if($Inventarisdetail->kondisi_barang=='dipinjam')<option value="dipinjam" selected>Dipinjam</option>@else<option value="dipinjam">Dipinjam</option>@endif
            

        </select>
     
        <small class="text-danger">{{ $errors->first('kondisi_barang') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('petugas') ? ' has-error' : '' }}">
    {!! Form::label('dokter_id', 'Petugas', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-8">
    <select class="form-control chosen-select" name="petugas">
        <option value="">[Semua]</option>
        @foreach (Modules\Pegawai\Entities\Pegawai::select('id', 'nama')->get() as $key => $d)
        <option value="{{ $d->id }}">{{ $d->nama }}</option>
        @endforeach
        </select>
    <small class="text-danger">{{ $errors->first('Petugas') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    <a href="{{ url('/backoffice/Inv-mutasi') }}" class="btn btn-warning btn-flat">Batal</a>
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
