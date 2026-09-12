<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-user text-grey-google"></i>
		<span>Direksi</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('/direksi/laporan') }}"><i class="fa fa-pie-chart"></i> <span> Laporan </span></a></li>
		
	</ul>
</li>