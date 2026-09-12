<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'}}">
	<a href="#">
		<i class="fa fa-desktop text-grey-google"></i>
		<span>Rekam Medis</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		{{--<li class="treeview">
			<a href="#">
				<i class="fa fa-desktop"></i> <span>Antrian Rawat Jalan</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>

			<ul class="treeview-menu">
				<li><a href="{{ url('antrian/daftarantrian') }}"><i class="fa fa-circle-o"></i> <span>Loket 1 </span></a></li>
				<li><a href="{{ url('antrian2/daftarantrian') }}"><i class="fa fa-circle-o"></i> <span>Loket 2 </span></a></li>
				<li><a href="{{ url('antrian3/daftarantrian') }}"><i class="fa fa-circle-o"></i> <span>Loket 3 </span></a></li>
				<li><a href="{{ url('antrian4/daftarantrian') }}"><i class="fa fa-circle-o"></i> <span>Loket 4 </span></a></li>
				<li><a href="{{ url('antrian5/daftarantrian') }}"><i class="fa fa-circle-o"></i> <span>Loket 5 </span></a></li>
				<li><a href="{{ url('antrian6/daftarantrian') }}"><i class="fa fa-circle-o"></i> <span>Loket 6 </span></a></li>
			</ul>
		</li> --}}

		{{-- <li><a href="{{ url('frontoffice/rawat-darurat') }}"><i class="fa fa-ambulance"></i> <span>Rawat Darurat</span></a></li> --}}
		{{-- <li><a href="{{ url('frontoffice/rawat-inap') }}"><i class="fa fa-bed"></i> <span>Rawat Inap</span></a></li> --}}
		<li><a href="{{ url('frontoffice/supervisor') }}"><i class="fa fa-edit"></i> <span>Supervisor</span></a></li>
		<li><a href="{{ url('frontoffice/laporan') }}"><i class="fa fa-pie-chart"></i> <span>Laporan</span></a></li>
		<li><a href="{{ url('frontoffice/cetak') }}"><i class="fa fa-print"></i> <span>Cetak</span></a></li>
		{{--- <li><a href="{{ url('frontoffice/cetak-perjanjian') }}"><i class="fa fa-print"></i> <span>Cetak Perjanjian</span></a></li> ---}}
	</ul>
</li>