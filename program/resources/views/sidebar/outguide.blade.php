<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-ambulance text-grey-google"></i>
		<span>Out/In Guide</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('frontoffice/outgate') }}"><i class="fa fa-ambulance"></i> <span>Out Guide</span></a></li>
		<li><a href="{{ url('frontoffice/inguide') }}"><i class="fa fa-ambulance"></i> <span>In Guide</span></a></li>
	</ul>
</li>