<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-television text-grey-google"></i>
		<span>Informasi</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		{{--<li><a href="{{ url('/jadwal-dokter') }}"><i class="fa fa-circle-o"></i> <span>Informasi Inventaris Ruangan</span></a></li>--}}
		<li><a href="{{ url('/jadwal-dokter') }}"><i class="fa fa-circle-o"></i> <span>Jadwal Dokter dan klinik</span></a></li>
		<li><a href="{{ url('/frontoffice/laporan/dokter') }}"><i class="fa fa-circle-o"></i> <span>Laporan Poli Hari Ini</span></a></li>
		<li><a href="{{ url('/frontoffice/laporan/kunjungan') }}"><i class="fa fa-television"></i> <span>Informasi Rawat Jalan</span></a></li>
		<li><a href="{{ url('/informasi') }}"><i class="fa fa-television"></i> <span>Dokumen Surat</span></a></li>
		{{--<li><a href="{{ url('/informasi-rawat-inap') }}"><i class="fa fa-television"></i> <span> Informasi Rawat Inap </span></a></li>
		<li><a href="{{ url('/bed') }}"><i class="fa fa-television"></i> <span>Informasi Ketersediaan Bed</span></a></li>--}}
	</ul>
</li>