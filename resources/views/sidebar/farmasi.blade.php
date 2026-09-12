<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' }}">
	<a href="#">
		<i class="fa fa-desktop text-grey-google"></i>
		<span>Farmasi / Apotek</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('antrian/farmasi') }}"><i class="fa fa-circle-o"></i> <span>Antrian Farmasi </span></a></li>
		<li><a href="#"><span> - </span></a></li>
		<li><a href="{{ url('masterobat') }}"><i class="fa fa-gears"></i> <span> Master Obat</span></a></li>
		<li><a href="{{ url('retur') }}"><i class="fa fa-gears"></i> <span> Retur Obat ke Logistik</span></a></li>
		
		{{--<li><a href="{{ url('masterobat') }}"><i class="fa fa-gears"></i> <span>Cek Stok barang</span></a></li>--}}
		<li><a href="{{ url('po') }}"><i class="fa fa-gears"></i> <span> Order Obat ke Logistik</span></a></li>
		<li><a href="{{ url('dist') }}"><i class="fa fa-gears"></i> <span> Distribusi Obat Depo</span></a></li>
		<li><a href="{{ url('penjualan/epo') }}"><i class="fa fa-money"></i> <span> Permintaan Ranap</span></a></li>
		<li><a href="{{ url('penjualan') }}"><i class="fa fa-history"></i> <span> Riwayat Penjualan </span></a></li>
		<li><a href="#"><span> - </span></a></li>
		{{--<li><a href="#"><i class="fa fa-text-width"></i> <span> Aturan Pakai </span></a></li>--}}
		<!--li><a href="{{ url('farmasi/etiket') }}"><i class="fa fa-text-width"></i> <span> Aturan Pakai </span></a></li-->
		<li><a href="{{ url('farmasi/laporan') }}"><i class="fa fa-pie-chart"></i> <span> Laporan </span></a></li>
		<li><a href="{{ url('frontoffice/cetak') }}"><i class="fa fa-print"></i> <span>Cetak</span></a></li>
		<li><a href="{{ url('/pasien') }}"><i class="fa fa-user-md"></i> <span> Data Pasien </span></a></li>
	</ul>
</li>