<meta name="_token" content="{{ csrf_token() }}"/>
<div class="panel panel-default no-border">
	<div class="panel-heading bg-primary">
		<h3 class="panel-title" style="color:white;">Antrian</h3>
	</div>
	<div class="panel-body no-padding">
		<div class='table-responsive'>
			<table class='table table-striped table-bordered table-hover table-condensed'>
				<thead>
					<tr>
						<th class="text-center">Antrian</th>
						<!--th>Waktu Antri</th-->
						<th class="text-center">Panggil</th>
					</tr>
				</thead>
				<tbody>
					@if($antrian!=null)
						@foreach ($antrian as $key => $d)
							<tr>
								<td class="text-center">{{ $d->nomor }}</td>
								<!--td>{{ $d->created_at }}</td-->
								<td class="text-center">
									<a href="#" id="click-panggil" class="btn btn-info btn-sm btn-flat"><i class="fa fa-microphone"></i></a>
								</td>
							</tr>
							<input type="hidden" value="{{$d->id}}" id="id_antrian">
						@endforeach
					@endif
					<input type="hidden" value="{{$loket}}" id="loket">
				</tbody>
			</table>
		</div>
	</div>
	<div class="panel-footer bg-primary"></div>
</div>
<script>
$('#click-panggil').on('click', function () {
	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
		},
		type: 'POST',
		url: '/antrian/panggil',
		data: {id: $("#id_antrian").val(), loket: $("#loket").val()},
		success: function (data) {
			if(data.status == false) {
				alert(data.message);
			}else if(data.status == true) {
				window.location.href = '/antrian/daftarantrian/'+$("#loket").val();
			}
		}
	});
});
</script>