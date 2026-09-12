<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-user-md text-grey-google"></i>
		<span>Penata Jasa RJ</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu"> {{--rawat-jalan/billing--}}
		@if(Auth::user()->role()->first()->name=='dokter' or Auth::user()->role()->first()->name=='adminpoli')
		<li><a href="{{ url('tindakan/dokter') }}"><i class="fa fa-money"></i> <span> Penata Jasa  </span></a></li>
		<li><a href="{{ url('/pendapatan_dokter') }}"><i class="fa fa-file"></i> <span> Laporan</span></a></li>
		<li><a href="{{ url('/pasien') }}"><i class="fa fa-user-md"></i> <span> Data Pasien </span></a></li>
		@else
		<li><a href="{{ url('tindakan') }}"><i class="fa fa-money"></i> <span> Penata Jasa  </span></a></li>
		<li><a href="{{ url('rawat-jalan/laporan') }}"><i class="fa fa-pie-chart"></i> <span> Laporan </span></a></li>
		<li><a href="{{ url('frontoffice/supervisor/ubahdpjp') }}"><i class="fa fa-database"></i> <span> Ubah DPJP </span></a></li>
		<li><a href="{{ url('/pasien') }}"><i class="fa fa-user-md"></i> <span> Data Pasien </span></a></li>
		@endif
		
	</ul>
</li>