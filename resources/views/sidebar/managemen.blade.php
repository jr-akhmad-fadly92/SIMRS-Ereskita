<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-gears text-grey-google"></i>
		<span>Pengaturan</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' ? 'active' : '' }}">
			<a href="#">
				<i class="fa fa-hospital-o"></i> <span>Konfigurasi</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="{{ url('/config/app') }}"><i class="fa fa-circle-o"></i> <span>Konfigurasi Umum</span></a></li>
				<li><a href="{{ url('/fasilitas') }}"><i class="fa fa-circle-o"></i> <span>Fasilitas</span></a></li>
			</ul>
		</li>
		<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' ? 'active' : '' }}">
			<a href="#">
				<i class="fa fa-user"></i> <span>Pengguna</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="{{ url('/role') }}"><i class="fa fa-circle-o"></i> <span>Hak Akses</span></a></li>
				
				<li><a href="{{ url('/pegawai') }}"><i class="fa fa-circle-o"></i> <span>Pegawai</span></a></li>
				<li><a href="{{ url('/user') }}"><i class="fa fa-circle-o"></i> <span>Pengguna</span></a></li>
			</ul>
		</li>
		<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' ? 'active' : '' }}">
			<a href="#">
				<i class="fa fa-money"></i> <span>Keuangan</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="{{ url('/tahuntarif') }}"><i class="fa fa-circle-o"></i> <span>Tahun Tarif Aktif</span></a></li>
				<!--li><a href="{{ url('/mastersplit') }}"><i class="fa fa-circle-o"></i> <span>Split Tarif</span></a></li-->
				<li><a href="{{ url('/kategoriheader') }}"><i class="fa fa-circle-o"></i> <span>Kategori Header</span></a></li>
				<li><a href="{{ url('/kategoritarif') }}"><i class="fa fa-circle-o"></i> <span>Kategori Tarif</span></a></li>
				<li><a href="{{ url('/kategoritarif/pelaksana') }}"><i class="fa fa-circle-o"></i> <span>Kategori Tarif Pelaksana</span></a></li>
				<li><a href="{{ url('/tarif') }}"><i class="fa fa-circle-o"></i> <span>Tarif Tindakan</span></a></li>
				<li><a href="{{ url('/biayaregistrasi') }}"><i class="fa fa-circle-o"></i> <span>Biaya Pendaftaran</span></a></li>
				<li><a href="{{ url('/mapping-biaya') }}"><i class="fa fa-circle-o"></i> <span>Group Tindakan</span></a></li>
				<li><a href="{{ url('/mastermapping') }}"><i class="fa fa-circle-o"></i> <span>Tarif E-Klaim</span></a></li>
			</ul>
		</li>
		<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' ? 'active' : '' }}">
			<a href="#">
				<i class="fa fa-stethoscope"></i> <span>Medis</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="{{ url('/politype') }}"><i class="fa fa-circle-o"></i> <span>Kategori Klinik</span></a></li>
				<li><a href="{{ url('/poli') }}"><i class="fa fa-circle-o"></i> <span>Master Klinik</span></a></li>
				<li><a href="{{ url('/instalasi') }}"><i class="fa fa-circle-o"></i> <span>Master Instalasi</span></a></li>
				<li><a href="{{ url('/kelompokkelas') }}"><i class="fa fa-circle-o"></i> <span>Master Kelompok Kamar</span></a></li>
				<li><a href="{{ url('/kelas') }}"><i class="fa fa-circle-o"></i> <span>Master Kelas Kamar</span></a></li>
				<li><a href="{{ url('/kamar') }}"><i class="fa fa-circle-o"></i> <span>Master Kamar</span></a></li>
				<li><a href="{{ url('/bed') }}"><i class="fa fa-circle-o"></i> <span>Master Bed</span></a></li>
				<li><a href="{{ url('/icd9') }}"><i class="fa fa-circle-o"></i> <span>Master ICD 9</span></a></li>
				<li><a href="{{ url('/icd10') }}"><i class="fa fa-circle-o"></i> <span>Master ICD 10</span></a></li>
			</ul>
		</li>
		
		<!--li><a href="{{ url('kontrolpanel/import') }}"><i class="fa fa-upload"></i> <span>Import</span></a></li-->
	</ul>
</li>