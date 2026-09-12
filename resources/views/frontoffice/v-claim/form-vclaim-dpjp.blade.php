@extends('master')
@section('header')
  <h1>V-Claim Peserta<small></small></h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
			<span class="input-group-btn">
				<a class="btn btn-success" href="">REFRESH</a>
			</span>
		</div>
    <div class="box-body">			
			<div class="col-md-6">
				<h5><b>DPJP RAWAT JALAN</h5>
				<table class="table" style="width:100%;">
					<tr>
						<th>NO</th>
						<th>KODE</th>
						<th>NAMA</th>
					<tr>
					@isset($dpjp_rj)
						@if($dpjp_rj!=null)
							@php $no=1; @endphp
							@foreach($dpjp_rj as $keydt => $dt)
								<tr>
									<td>{{$no++}}</td>
									<td>{{$keydt}}</td>
									<td>{{strtoupper($dt)}}</td>
								<tr>
							@endforeach
						@endif
					@endisset
				</table>
			</div>
			<div class="col-md-6">
				
				<h5><b>DPJP RAWAT INAP</h5>
				<table class="table" style="width:100%;">
					<tr>
						<th>NO</th>
						<th>KODE</th>
						<th>NAMA</th>
					<tr>
					@isset($dpjp_ri)
						@if($dpjp_ri!=null)
							@php $no=1; @endphp
							@foreach($dpjp_ri as $keys => $dpjpri)
									<tr>
										<td>{{$no++}}</td>
										<td>{{$dpjpri->kode}}</td>
										<td>{{strtoupper($dpjpri->nama)}}</td>
									<tr>
							@endforeach
						@endif
					@endisset
				</table>
			</div>
    </div>
  </div>
@endsection
