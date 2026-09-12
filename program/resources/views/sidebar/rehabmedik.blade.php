<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-keyboard-o text-grey-google"></i>
		<span>Reham Medik</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('rehabmedik/billing') }}"><i class="fa fa-money"></i> <span> Billing System</span></a></li>
		<li><a href="{{ url('rehabmedik/hasil') }}"><i class="fa fa-keyboard-o"></i> <span> Hasil Radiologi</span></a></li>
		<li><a href="{{ url('rehabmedik/laporan') }}"><i class="fa fa-pie-chart"></i> <span> Laporan</span></a></li>
	</ul>
</li>