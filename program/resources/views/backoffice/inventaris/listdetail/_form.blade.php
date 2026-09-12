<div class="form-group{{ $errors->has('no_inv') ? ' has-error' : '' }}">
    {!! Form::label('no_inv', 'Nomor Inventaris', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        @if(isset($Inventarisdetail))
        {!! Form::text('no_inv', null, ['class' => 'form-control','readonly']) !!}
        @else
        {!! Form::text('no_inv', null, ['class' => 'form-control']) !!}
        
        @endif
        <small class="text-danger">{{ $errors->first('kode_barang') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kode_barang') ? ' has-error' : '' }}">
    {!! Form::label('kode_barang', 'Kode Barang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
    @if(isset($Inventarisdetail))
        {!! Form::text('kode_barang', $Inventarisdetail->kode_barang, ['class' => 'form-control','readonly']) !!}
    @else
        {!! Form::text('kode_barang', $Inventarisglobal->kode_barang, ['class' => 'form-control','readonly']) !!}
    @endif
        <small class="text-danger">{{ $errors->first('kode_barang') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('ruangan') ? ' has-error' : '' }}">
    {!! Form::label('ruangan', 'Ruangan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control" name="ruangan" id="ruangan">
          <option value="">==pilih==</option>
          @foreach (App\Masterruangan::all() as $d)
            @if (isset($Inventarisdetail) && $Inventarisdetail->ruangan == $d->id)
              <option value="{{ $d->id }}" selected>{{ $d->ruangan }}</option>
            @else
              <option value="{{ $d->id }}">{{ $d->ruangan }}</option>
            @endif
          @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('ruangan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('lokasi') ? ' has-error' : '' }}">
    {!! Form::label('lokasi', 'Lokasi', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
          <select class="form-control select2" name="lokasi" id="lokasi">
						@if (!empty ($Inventarisdetail->regency_id))
							<option value="{{ $Inventarisdetail->lokasi }}">{{ App\Masterlokasi::find($Inventarisdetail->lokasi)->lokasi }}</option>
						@elseif (session('lokasi'))
							<option value="{{ session('lokasi') }}">{{ (session('lokasi')!='') ? baca_kabupaten(session('lokasi')) : 0 }}</option>
						@endif
					</select>
        <small class="text-danger">{{ $errors->first('lokasi') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('tanggal_pengadaan') ? ' has-error' : '' }}">
    {!! Form::label('tanggal_pengadaan', 'Tanggal Pengadaan', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
    {!! Form::text('tanggal_pengadaan', (!empty($Inventarisdetail->tanggal_pengadaan)) ? tgl_indo($Inventarisdetail->tanggal_pengadaan) : null, ['class' => 'datepicker form-control', 'id'=>'tanggal_pengadaan']) !!}
        <small class="text-danger">{{ $errors->first('tanggal_pengadaan') }}</small>
    </div>
</div>
<div class="form-group{{ $errors->has('kondisi_barang') ? ' has-error' : '' }}">
    {!! Form::label('kondisi_barang', 'Kondisi Barang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
          <select class="form-control" name="kondisi_barang">

            <option value="ada">Ada</option>
            <option value="rusak" >Rusak</option>
            <option value="hilang" >Hilang</option>
            <option value="perbaikan" >Perbaikan</option>
            <option value="dipinjam" >Dipinjam</option>
            
          </select>
       
        <small class="text-danger">{{ $errors->first('kondisi_barang') }}</small>
    </div>
</div>

<div class="form-group{{ $errors->has('asal_barang') ? ' has-error' : '' }}">
    {!! Form::label('asal_barang', 'Asal Barang', ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-9">
        <select class="form-control" name="asal_barang">

          <option value="hibah">Hibah</option>
          <option value="beli" >Beli</option>
          
        </select>
        <small class="text-danger">{{ $errors->first('asal_barang') }}</small>
    </div>
</div>
<div class="btn-group pull-right">
    @if(isset($Inventarisdetail))
    <a href="{{ url('/backoffice/Inv-detail/'.$Inventarisdetail->kode_barang) }}" class="btn btn-warning btn-flat">Batal</a>
    @else
    <a href="{{ url('/backoffice/Inv-detail/'.$Inventarisglobal->kode_barang) }}" class="btn btn-warning btn-flat">Batal</a>
    
    @endif
    {!! Form::submit("Simpan", ['class' => 'btn btn-success btn-flat']) !!}
</div>
