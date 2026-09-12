<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' ? 'active' : '' }}">
	<a href="#">
		<i class="fa fa-building text-grey-google"></i>
		<span>Back Office</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('/backoffice') }}"><i class="fa fa-circle-o"></i> <span>Inventaris</span></a></li>
		<li><a href="{{ url('/backoffice/master') }}"><i class="fa fa-circle-o"></i> <span>Master</span></a></li>
	</ul>
</li>