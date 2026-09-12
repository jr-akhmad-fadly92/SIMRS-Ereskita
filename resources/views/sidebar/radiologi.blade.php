<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-keyboard-o text-grey-google"></i>
		<span>Radiologi</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('radiologi/tindakan-pasien') }}"><i class="fa fa-money"></i> <span> Penata Jasa</span></a></li>
		<!--li><a href="{{ url('radiologi/hasil') }}"><i class="fa fa-keyboard-o"></i> <span> Hasil Radiologi</span></a></li-->
		<li><a href="{{ url('radiologi/laporan') }}"><i class="fa fa-pie-chart"></i> <span> Laporan</span></a></li>
		<li><a href="{{ url('/pasien') }}"><i class="fa fa-user-md"></i> <span> Data Pasien </span></a></li>
	</ul>
</li>