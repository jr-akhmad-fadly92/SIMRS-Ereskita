<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-money text-grey-google"></i>
		<span>Tarif & Tindakan</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		@role(['operasi','radiologi','administrator'])
			<li><a href="{{ url('tindakan/data') }}"><i class="fa fa-money"></i> <span> Tindakan </span></a></li>
		@endrole
		<li><a href="{{ url('tarif') }}"><i class="fa fa-money"></i> <span> Tarif </span></a></li>
	</ul>
</li>