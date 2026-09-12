@extends('master')
@section('header')
  <h1>Loket - Rawat Darurat </h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-body">
		@if(Request::path()=='frontoffice/daftar-bayi')
			@php $url = 'bayi'; @endphp
		{{--	<a href="{{url('frontoffice/daftar-bayi')}}" class="btn btn-primary btn-flat btn-sm">Pendaftaran Bayi</a>--}}
		@else
			@php $url = 'non-bayi'; @endphp
			<b>Pasien Baru: </b>
			<a href="{{ url('/registrasi/igd/jkn') }}" class="btn btn-primary btn-flat btn-sm">JKN</a>
			<a href="{{ url('/registrasi/igd/umum') }}" class="btn btn-success btn-flat btn-sm">NON JKN</a>
		@endif
    <div class="table-responsive" style="margin-top: 10px;">
      <table class="table table-hover table-condensed table-bordered">
        <thead>
          <tr>
            <th>{{ (Request::path()=='frontoffice/daftar-bayi') ? 'NAMA NYONYA' : 'NAMA' }}</th>
            <th>NO. RM</th>
            <th>{{ (Request::path()=='frontoffice/daftar-bayi') ? 'NENEK' : 'IBU KANDUNG' }}</th>
            <th>TGL LAHIR</th>
            <th>ALAMAT</th>
            <th>ASURANSI</th>
            <th>JKN</th>
            <th>NON JKN</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
    </div>
  </div>
@endsection

@section('script')
  <!-- jQuery 3 -->
{{-- <script src="{{ asset('style') }}/bower_components/jquery/dist/jquery.min.js"></script> --}}
<script type="text/javascript">
    $('.table').DataTable({
      'language': {
          "url": "/json/pasien.datatable-language.json",
      },
      pageLength  : 10,
      paging      : true,
      lengthChange: false,
      searching   : true,
      ordering    : false,
      info        : false,
      autoWidth   : false,
      destroy     : true,
      processing  : true,
      serverSide  : true,
      ajax: '/pasien/search-pasien-igd/<?php echo $url; ?>',
      columns: [
				{data: 'nama'},
				{data: 'no_rm'},
				{data: 'ibu_kandung'},
				{data: 'tgllahir'},
        {data: 'alamat'},
        {data: 'asuransi'},
				{data: 'jkn', searchable: false, sClass: 'text-center'},
				{data: 'non-jkn', searchable: false, sClass: 'text-center'}
      ]
    });

</script>
@endsection
