<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-check text-grey-google"></i>
		<span>Verifikator Keuangan</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('kasir/verifikasi-kasa') }}"><i class="fa fa-check"></i> <span> Verifikator Rawat Jalan</span></a></li>
		<li><a href="{{ url('kasir/verifikasi') }}"><i class="fa fa-check"></i> <span> Verifikator Rawat Inap</span></a></li>
		<li><a href="{{ url('/pasien') }}"><i class="fa fa-user-md"></i> <span> Data Pasien </span></a></li>
		
	</ul>
</li>