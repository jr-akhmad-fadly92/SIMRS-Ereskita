<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' }}">
	<a href="#">
		<i class="fa fa-laptop text-grey-google"></i>
		<span>Admission + Loket</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li class="treeview">
			<a href="#">
				<i class="fa fa-desktop"></i> <span>Antrian Rawat Jalan</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>

			<ul class="treeview-menu">
				<li><a href="{{ url('antrian/daftarantrian/1') }}"><i class="fa fa-circle-o"></i> <span>Loket 1 </span></a></li>
				<li><a href="{{ url('antrian/daftarantrian/2') }}"><i class="fa fa-circle-o"></i> <span>Loket 2 </span></a></li>
			</ul>
		</li>
		{{--<li><a href="{{ url('frontoffice/rawat-darurat') }}"><i class="fa fa-ambulance"></i> <span>Pendaftaran IGD</span></a></li>
		<li><a href="{{ url('/admission') }}"><i class="fa fa-hotel"></i> <span>Pendaftaran Ranap</span></a></li>
		<li><a href="{{ url('frontoffice/daftar-bayi') }}"><i class="fa fa-user"></i> <span>Pendaftaran Bayi</span></a></li>--}}
		<li><a href="{{ url('frontoffice/supervisor/ubahdpjp') }}"><i class="fa fa-database"></i> <span> Ubah Data Registrasi </span></a></li>
		<li><a href="{{ url('/frontoffice/supervisor/hapusregistrasi') }}"><i class="fa fa-user-o"></i> <span>Hapus Pasien</span></a></li>
		<li><a href="{{ url('frontoffice/cetak') }}"><i class="fa fa-print"></i> <span>Cetak</span></a></li>
		<li><a href="{{ url('/pasien') }}"><i class="fa fa-user-md"></i> <span> Data Pasien </span></a></li>
	</ul>
</li>