<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-database text-grey-google"></i>
		<span>Bridging</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' ? 'active' : '' }}">
			<a href="#">
				<i class="fa fa-desktop"></i> <span>V-Claim</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="#"><i class="fa fa-circle-o"></i> <span>DPJP</span></a></li> <!-- {{ url('frontoffice/v-claim/dpjp') }} -->
				<li><a href="{{ url('frontoffice/v-claim/peserta') }}"><i class="fa fa-circle-o"></i> <span>Peserta</span></a></li>
				<li><a href="{{ url('frontoffice/v-claim/sep-rj') }}"><i class="fa fa-circle-o"></i> <span>SEP RJ</span></a></li>
				<li><a href="{{ url('frontoffice/v-claim/sep-ri') }}"><i class="fa fa-circle-o"></i> <span>SEP RI</span></a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> <span>Referensi</span></a></li>
				<li><a href="#"><i class="fa fa-circle-o"></i> <span>Monitoring</span></a></li>
			</ul>
		</li>
		<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' ? 'active' : '' }}">
			<a href="#">
				<i class="fa fa-desktop"></i> <span>E-Claim</span>
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			<ul class="treeview-menu">
				<li><a href="{{ url('frontoffice/input_diagnosa_rawatjalan') }}"><i class="fa fa-circle-o"></i> <span>Diagnosa RJ</span></a></li>
				<li><a href="{{ url('frontoffice/input_diagnosa_rawatinap') }}"><i class="fa fa-circle-o"></i> <span>Diagnosa RI</span></a></li>
				<li><a href="{{ url('frontoffice/e-claim/rawat-jalan') }}"><i class="fa fa-circle-o"></i> <span>Bridging E-Claim RJ</span></a></li>
				<li><a href="{{ url('frontoffice/e-claim/rawat-inap') }}"><i class="fa fa-circle-o"></i> <span>Bridging E-Claim RI</span></a></li>
			</ul>
		</li>
		<li><a href="{{ url('/pasien') }}"><i class="fa fa-user"></i><span> Data Pasien</span></a></li>
		<li><a href="{{ url('/frontoffice/lap-rekammedis') }}"><i class="fa fa-paperclip"></i><span> Laporan</span></a></li>
		@role('supervisor-costing')
			<li><a href="#"><i class="fa fa-paperclip"></i><span> Supervisor Costing</span></a></li>
		@endrole
	</ul>
</li>