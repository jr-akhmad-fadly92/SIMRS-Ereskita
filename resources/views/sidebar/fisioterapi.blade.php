<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' }}">
	<a href="#">
		<i class="fa fa-hand-lizard-o text-grey-google"></i>
		<span>Fisioterapi</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('penunjang/tindakan-pasien') }}"><i class="fa fa-money"></i> <span> Penata Jasa </span></a></li>
	</ul>
</li>