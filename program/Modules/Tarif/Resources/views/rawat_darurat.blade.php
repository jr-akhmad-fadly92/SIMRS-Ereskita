@extends('master')

@section('header')
  <h1>Keuangan - Tarif Rawat Darurat </h1>
@endsection

@section('content')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">
          Data Master Tarif &nbsp;
          <a href="{{ url('tarif/create/TG') }}" class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a>
        </h3>
      </div>
      <div class="box-body">
          {!! Form::open(['method' => 'POST', 'route' => 'tarif.rawatdarurat-by-kategori-header', 'class' => 'form-horizontal']) !!}

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('tahuntarif') ? ' has-error' : '' }}">
                      {!! Form::label('tahuntarif', 'Tahun Tarif', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('tahuntarif', $thn_tarif, (Request::segment(3)) ? Request::segment(3) : configrs()->tahuntarif, ['class' => 'chosen-select']) !!}
                          <small class="text-danger">{{ $errors->first('tahuntarif') }}</small>
                      </div>
                  </div>

                  <div class="form-group{{ $errors->has('kategoriheader_id') ? ' has-error' : '' }}">
                      {!! Form::label('kategoriheader_id', 'Kategori Tarif', ['class' => 'col-sm-4 control-label']) !!}
                      <div class="col-sm-8">
                          {!! Form::select('kategoriheader_id', $kh, (Request::segment(4)) ? Request::segment(4) : '2', ['class' => 'chosen-select', 'onchange'=>'this.form.submit()']) !!}
                          <small class="text-danger">{{ $errors->first('kategoriheader_id') }}</small>
                      </div>
                  </div>

                </div>
              </div>

          {!! Form::close() !!}
            <hr>
        <div class='table-responsive'>
          <table class='table table-striped table-bordered table-hover table-condensed' >
              <thead>
                <tr>
                  <th class="text-center" style="vertical-align: middle;">No</th>
                  <th class="text-center" style="vertical-align: middle;">Thn Tarif</th>
                  <th class="text-center" style="vertical-align: middle;">Nama</th>
                  <th class="text-center" style="vertical-align: middle;">Total</th>
                  @foreach (App\Mastersplit::where('kategoriheader_id', 1)->get() as $key => $d)
                    <th class="text-center" style="vertical-align: middle;">{{ $d->nama }}</th>
                  @endforeach
                  <th class="text-center" style="vertical-align: middle;">Edit</th>
                </tr>
              </thead>
            <tbody>
              @foreach ($tarif as $key => $d)
                  @php
                    $split = App\Split::where('tarif_id', $d->id)->get();
                  @endphp
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $d->tahuntarif->tahun }}</td>
                  <td>{{ $d->nama }}
                  <td>{{ number_format($d->total) }}</td>
					<!--
                    @if ($split->count() > 0)
                      @foreach ($split as $key => $r)
                       <td class="text-right">{{ number_format($r->nominal) }} </td>
                      @endforeach
                    @else
                      @for ($i=0; $i < 7; $i++)
                        <td class="text-right">0</td>
                      @endfor
                    @endif
					-->
                  <td>
                    <a href="{{ url('tarif/'.$d->id.'/edit/TA') }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
@stop
