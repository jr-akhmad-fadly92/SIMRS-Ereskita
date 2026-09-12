<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-user-md text-grey-google"></i>
		<span>Pendaftaran IGD</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('frontoffice/rawat-darurat') }}"><i class="fa fa-ambulance"></i> <span>Rawat Darurat</span></a></li>
		<li><a href="{{ url('frontoffice/supervisor/ubahdpjp') }}"><i class="fa fa-edit"></i> <span>Ubah DPJP</span></a></li>
		<li><a href="{{ url('pasien') }}"><i class="fa fa-user-md"></i> <span>Data Pasien</span></a></li>
	</ul>
</li>