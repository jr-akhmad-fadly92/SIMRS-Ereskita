@extends('master')

@section('header')
  <h1>Kofigurasi - Tahun Tarif</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Tambah Tahun Tarif &nbsp;
        </h3>
      </div>
      <div class="box-body">
      <form method="post" action="/masterdietpasien/update">
            {{ csrf_field() }}
           <div class="form-group">
           @foreach($gizi as $d)
                <label>Katagori Diet Pasien</label>
                <select class="form-control" name="kategori_menu">

                @if($d->kategori_menu=='Nasi')<option value="Nasi" selected>Nasi</option>@else <option value="Nasi">Nasi</option> @endif
                @if($d->kategori_menu=='lauk_hewani')<option value="lauk_hewani" selected>Lauk Hewani</option>@else <option value="lauk_hewani">Lauk Hewani</option> @endif
                @if($d->kategori_menu=='lauk_nabati')<option value="lauk_nabati" selected>Lauk Nabati</option>@else <option value="lauk_nabati">Lauk Nabati</option> @endif
                @if($d->kategori_menu=='sayur')<option value="sayur" selected>Sayur</option>@else <option value="sayur">Sayur</option> @endif
                @if($d->kategori_menu=='buah')<option value="buah" selected>Buah</option>@else <option value="buah">Buah</option> @endif
                @if($d->kategori_menu=='snack')<option value="snack" selected>Snack</option>@else <option value="snack">Snack</option> @endif
                
                </select>
                @if($errors->has('kategori_menu'))
                    <div class="text-danger">
                        {{ $errors->first('kategori_menu')}}
                    </div>
                @endif
            </div>
            <div class="form-group" hidden="true">
                
                <input type="text" name="id" class="form-control" placeholder="contoh : nasi putih" value="{{$d->id}}">
                 
            </div>
            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" placeholder="contoh : nasi putih" value="{{$d->nama_menu}}">
                  @if($errors->has('nama_menu'))
                    <div class="text-danger">
                        {{ $errors->first('nama_menu')}}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label>Energi</label>
                <input type="text" name="energi_kkal" class="form-control" placeholder="contoh : 36" value="{{$d->energi_kkal}}">
                  @if($errors->has('energi_kkal'))
                    <div class="text-danger">
                        {{ $errors->first('energi_kkal')}}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label>Protein</label>
                <input type="text" name="protein_gr" class="form-control" placeholder="contoh : 36" value="{{$d->protein_gr}}">
                  @if($errors->has('protein_gr'))
                    <div class="text-danger">
                        {{ $errors->first('protein_gr')}}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Simpan">
            </div>
            @endforeach
            </form>
      </div>
    </div>
@stop
