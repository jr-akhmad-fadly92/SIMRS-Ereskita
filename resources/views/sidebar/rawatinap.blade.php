<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-bed text-grey-google"></i>
		<span>Penata Jasa RI</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('rawat-inap/billing') }}"><i class="fa fa-circle-o"></i> <span> Billing System </span></a></li>
		<li><a href="{{ url('/frontoffice/supervisor/ubahdpjp') }}"><i class="fa fa-database"></i> <span>Ubah DPJP </span></a></li>
		<li><a href="{{ url('/pasien') }}"><i class="fa fa-user-md"></i> <span> Data Pasien </span></a></li>
		<!--li><a href="{{ url('rawat-inap/emr') }}"><i class="fa fa-stethoscope"></i> <span>E-Medical Record </span></a></li-->
		<li><a href="{{ url('rawatinap/lap-pengunjung') }}"><i class="fa fa-pie-chart"></i> <span>Laporan </span></a></li>
		<li><a href="{{ url('frontoffice/cetak') }}"><i class="fa fa-print"></i> <span>Cetak</span></a></li>
		<!--li><a href="{{ url('rawat-inap/askep') }}"><i class="fa fa-circle-o"></i> <span> Asuhan Keperawatan </span></a></li-->
	</ul>
</li>