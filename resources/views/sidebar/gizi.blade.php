<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-cutlery text-grey-google"></i>
		<span>Gizi</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('master-diet-pasien') }}"><i class="fa fa-gears"></i> <span>Master Program Diet</span></a></li>
		<li><a href="{{ url('mastergizi') }}"><i class="fa fa-gears"></i> <span>Master Gizi</span></a></li>
		<li><a href="{{ url('gizi-pasien') }}"><i class="fa fa-user"></i> <span>Gizi Pasien</span></a></li>
		<li><a href="{{ url('histori-gizi-pasien') }}"><i class="fa fa-user"></i> <span>Histori Gizi Pasien</span></a></li>
	</ul>
</li>