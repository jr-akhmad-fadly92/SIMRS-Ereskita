@extends('master')

@section('header')
  <h1>Master Bed Rumah Sakit</h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Bed &nbsp;
					@role(['administrator'])
          <a href="{{ route('bed.create') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
					@endrole
        </h3>
      </div>
      <div class="box-body">
        <table class='table table-striped table-bordered table-hover table-condensed' id='data'>
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Kelompok</th>
              <th>Kelas</th>
              <th>Kamar</th>
              <th>Status</th>
							@role(['administrator'])
              <th>Edit</th>
							@endrole
            </tr>
          </thead>
          <tbody>
            @foreach ($bed as $key => $d)
            <tr>
              <td>{{ $no++ }}</td>
              <td>{{ $d->nama }}</td>
              <td>{{ $d->kamar->kelompokkelas->kelompok }}</td>
              <td>{{ $d->kamar->kelas->nama }}</td>
              <td>{{ $d->kamar->nama }}</td>
              <td>
                @if ($d->reserved == 'Y')
									{{--href="{{ asset('bed/kosongkanbatal/'.$d->id) }}"--}}
									{{--onclick="return confirm('Yakin batal kosongkan Bed {{ strtoupper($d->nama) }}?')"--}}
                  <a class="btn btn-danger btn-sm btn-flat"><i class="fa fa-remove"></i></a> 
									Terisi
                @else
									{{--href="{{ url('bed/kosongkan/'.$d->id) }}"--}}
									{{--onclick="return confirm('Yakin Bed {{ strtoupper($d->nama) }} akan dikosongkan?')"--}}
                  <a class="btn btn-success btn-sm btn-flat"><i class="fa fa-check"></i></a> 
									Kosong
                @endif
              </td>
							@role(['administrator'])
              <td>
                <a href="{{ route('bed.edit', $d->id) }}" class="btn btn-info btn-sm btn-flat"><i class="fa fa-edit"></i></a>
              </td>
							@endrole
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
@stop
