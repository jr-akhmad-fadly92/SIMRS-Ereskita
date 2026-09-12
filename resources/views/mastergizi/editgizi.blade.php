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
      <form method="post" action="/gizi/update">
            {{ csrf_field() }}
            <div class="form-group" hidden="true">
                @foreach($idgizi as $id)
                <label>id</label>
                <input id="id" name="id" value="{{$id->id}}">
                @endforeach
            </div> 
           <div class="form-group ">

                <label>Nasi</label>
                <select id="nasi" name="nasi" class="form-control  @error('nasi') is-invalid @enderror">
                 
                  @foreach(App\MasterDietPasien::where('kategori_menu','Nasi')->get() as $data)
                  @if($arraygizi[1]==$data->nama_menu)
                  <option value="{{ $data->id }}" selected>{{ $data->nama_menu }}</option>
                  @else
                  <option value="{{ $data->id }}" >{{ $data->nama_menu }}</option>
                  @endif
                  @endforeach
                
                </select>
                
            </div>
            <div class="form-group">
                <label>Lauk Hewani</label>
                <select id="lauk_hewani" name="lauk_hewani" class="form-control  @error('lauk_hewani') is-invalid @enderror">
                 
                  @foreach(App\MasterDietPasien::where('kategori_menu','lauk_hewani')->get() as $data)
                  @if($arraygizi[2]==$data->nama_menu)
                  <option value="{{ $data->id }}" selected>{{ $data->nama_menu }}</option>
                  @else
                  <option value="{{ $data->id }}" >{{ $data->nama_menu }}</option>
                  @endif
                  @endforeach
                
                </select>
                
            </div>
            <div class="form-group">
                <label>Lauk Nabati</label>
                <select id="lauk_nabati" name="lauk_nabati" class="form-control  @error('lauk_nabati') is-invalid @enderror">
                 
                  @foreach(App\MasterDietPasien::where('kategori_menu','lauk_nabati')->get() as $data)
                  @if($arraygizi[3]==$data->nama_menu)
                  <option value="{{ $data->id }}" selected>{{ $data->nama_menu }}</option>
                  @else
                  <option value="{{ $data->id }}" >{{ $data->nama_menu }}</option>
                  @endif
                  @endforeach
               
                </select>
                
            </div>
            <div class="form-group">
                <label>Sayur</label>
                <select id="sayur" name="sayur" class="form-control  @error('sayur') is-invalid @enderror">
                 
                  @foreach(App\MasterDietPasien::where('kategori_menu','sayur')->get() as $data)
                  @if($arraygizi[4]==$data->nama_menu)
                  <option value="{{ $data->id }}" selected>{{ $data->nama_menu }}</option>
                  @else
                  <option value="{{ $data->id }}" >{{ $data->nama_menu }}</option>
                  @endif
                  @endforeach
              
                </select>
                
            </div>
            <div class="form-group">
                <label>Buah</label>
                <select id="buah" name="buah" class="form-control  @error('buah') is-invalid @enderror">
                 
                  @foreach(App\MasterDietPasien::where('kategori_menu','buah')->get() as $data)
                  @if($arraygizi[5]==$data->nama_menu)
                  <option value="{{ $data->id }}" selected>{{ $data->nama_menu }}</option>
                  @else
                  <option value="{{ $data->id }}" >{{ $data->nama_menu }}</option>
                  @endif
                  @endforeach
              
                </select>
                
            </div>
            <div class="form-group">
                <label>Snack</label>
                <select id="snack" name="snack" class="form-control  @error('snack') is-invalid @enderror">
                 
                  @foreach(App\MasterDietPasien::where('kategori_menu','snack')->get() as $data)
                  @if($arraygizi[6]==$data->nama_menu)
                  <option value="{{ $data->id }}" selected>{{ $data->nama_menu }}</option>
                  @else
                  <option value="{{ $data->id }}" >{{ $data->nama_menu }}</option>
                  @endif
                  @endforeach
               
                </select>
                
            </div>
            
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Simpan">
            </div>
            </form>
      </div>
    </div>
@stop
