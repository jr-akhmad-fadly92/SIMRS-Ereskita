<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' }}">
	<a href="#">
		<i class="fa fa-calculator text-grey-google"></i>
		<span>Kasir / Keuangan</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<!--li><a href="{{ url('kasir/transaksi') }}"><i class="fa fa-calculator"></i> <span> Transaksi</span></a></li-->
		<li><a href="{{ url('kasir/uang-titipan') }}"><i class="fa fa-calculator"></i> <span> Uang Titipan</span></a></li>
		<li><a href="{{ url('kasir/supervisor') }}"><i class="fa fa-edit"></i><span> Supervisor</span></a></li>
		<li><a href="{{ url('kasir/laporan') }}"><i class="fa fa-pie-chart"></i> <span>Laporan</span></a></li>
		<li><a href="{{ url('kasir/cetak') }}"><i class="fa fa-print"></i><span> Cetak</a></span></li>
		<li><a href="{{ url('kasir/keuangan/') }}"><i class="fa fa-calculator"></i><span> Keuangan</a></span></li>
		
	</ul>
</li>