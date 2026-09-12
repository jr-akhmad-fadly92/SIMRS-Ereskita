@extends('master')

@section('content')
  <div class="box box-primary">
    <div class="box-body">      
			<div class='table-responsive'>
				<div class="col-md-6 pull-left">
					<h4 style="margin-top:5px;">Laporan Dokter </h4>
				</div>
				<table class='table table-striped table-bordered table-hover table-condensed' id='data'>
					<thead>
						<tr>
							<th>No</th>
							<th>Poli</th>
							<th>Dokter</th>
							<th>Pengunjung</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($histreg as $key => $d)
							<tr>
								<td>{{ $no++ }}</td>
								<td>{{ $d->poli->nama }}</td>
								<td>{{ $d->pegawai->nama }}</td>
								<td>{{ $d->total }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
    </div>
    <div class="box-footer">
    </div>
  </div>
@endsection
