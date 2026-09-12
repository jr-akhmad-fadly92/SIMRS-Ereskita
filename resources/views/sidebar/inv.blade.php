<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-gears text-grey-google"></i>
		<span>Non Medis & Inv</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('depo-inv') }}"><i class="fa fa-gears"></i> <span> Order Inv </span></a></li>
		<li><a href="{{ url('depo-nonmedis') }}"><i class="fa fa-gears"></i> <span> Order Non Medis </span></a></li>
		<li><a href="{{url('list-inventaris/'.Auth::user()->role()->first()->id)}}"><i class="fa fa-gears"></i> <span> Data Inventaris </span></a></li>
	</ul>
</li>