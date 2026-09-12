<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-user text-grey-google"></i>
		<span>Operasi / IBS</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu"> {{--operasi/billing--}}
		<li><a href="{{ url('operasi/antrian') }}"><i class="fa fa-money"></i> <span> Penata Jasa </span></a></li>
		<li><a href="{{ url('operasi/laporan') }}"><i class="fa fa-pie-chart"></i><span> Laporan </span></a></li>
	</ul>
</li>