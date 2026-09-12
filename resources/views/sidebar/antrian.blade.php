<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'}}">
	<a href="#">
		<i class="fa fa-hospital-o text-grey-google"></i>
		<span>Antrian</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('antrian/antrian') }}"><i class="fa fa-hospital-o"></i><span> Antrian Rawat Jalan</span></a></li>
		<li><a href="{{ url('antrian/antrian-apotek') }}"><i class="fa fa-hospital-o"></i><span> Antrian Apotek</span></a></li>
	</ul>
</li>
