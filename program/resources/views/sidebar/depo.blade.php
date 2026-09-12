<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-gears text-grey-google"></i>
		<span>Obat</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('masterobat') }}"><i class="fa fa-gears"></i> <span> Master Obat </span></a></li>
		<li><a href="{{ url('depo-obat') }}"><i class="fa fa-gears"></i> <span> Order Obat </span></a></li>
		{{--<li class="treeview">
			<a href="#">
				<i class="fa fa-gears"></i> <span>Retur Obat</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>

			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> <span>Retur ke Farmasi</span></a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> <span>Retur dari Pasien</span></a></li>
			</ul>
		</li>--}}
	</ul>
</li>