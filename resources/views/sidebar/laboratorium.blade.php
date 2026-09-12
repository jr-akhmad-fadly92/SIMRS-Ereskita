<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-paperclip text-grey-google"></i>
		<span>Laboratorium</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('laboratorium/tindakan-pasien') }}"><i class="fa fa-money"></i> <span> Penata Jasa </span></a></li>
		<!--li><a href="{{ url('pemeriksaanlab') }}"><i class="fa fa-paperclip"></i> <span> Hasil </span></a></li-->
		<li><a href="{{ url('laboratorium/master') }}"><i class="fa fa-barcode"></i> <span>Master</span></a></li>
		<li><a href="{{ url('laboratorium/laporan') }}"><i class="fa fa-pie-chart"></i> <span> Laporan </span></a></li>
		<li><a href="{{ url('/pasien') }}"><i class="fa fa-user-md"></i> <span> Data Pasien </span></a></li>
	</ul>
</li>