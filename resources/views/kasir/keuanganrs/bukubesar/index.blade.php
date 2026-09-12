
@extends('master')
<style>
.inputjurnal{
	height: 300px;
	width:300px;
	display: none;
}
</style>
@section('head')

@endsection
@section('header')

  <h1>Buku Besar</h1>
@endsection

@section('content')
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title" style="font-weight:bold;">
      Daftar Akun &nbsp;
      </h3>
      <a href="{{url('/kasir/keuangan')}}" class="btn btn-success">Back</a>
    </div>
    <div class="box-body">
    
    
    @foreach($akun as $data)               		
						<div class="col-sm-3" style="margin: 3px auto;">
							<a href="{{url('/keuangan/buku-besar/'.$data->kode_keuangan)}}" class="btn btn-info btn-lg btn-block" style="font-size:16px;">{{$data->nama_akun}}</a>
						</div>
		@endforeach
		

    </div>
    
  </div>
  

  
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		$('#tombol').click(function(){
			$('.inputjurnal').fadeToggle(100);
		});
	});
 
  
  $(document).ready(function(){
      $('.periode').datepicker({
          format: "MM-yyyy",
          viewMode: "months", 
          minViewMode: "months"
      });
    });
 
</script>
@endsection
