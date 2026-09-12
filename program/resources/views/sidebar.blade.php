<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
	<!-- Sidebar Menu -->
	<ul class="sidebar-menu" data-widget="tree" style="margin-top:10px;padding-right:5px;">
		<li class="">
			<a href="{{ url('/dashboard') }}">
				<i class="fa fa-dashboard text-grey-google"></i>
				<span>Dashboard</span>
			</a>
		</li>
		@role('administrator')
			@include('sidebar/kontrolpanel')
		@endrole
		@role(['administrator','kepegawaian'])
			@include('sidebar/hrd')
		@endrole
		@role(['administrator','logistik'])
			@include('sidebar/backoffice')
		@endrole
		@role(['pimpinan', 'administrator'])
			@include('sidebar/direksi')
		@endrole
		@role(['verifikator', 'supervisor','administrator'])
			@include('sidebar/verifikator')
		@endrole
		@role(['costing','supervisor-costing','supervisor','administrator'])
			@include('sidebar/costing')
		@endrole
		@role(['antrian','administrator','admission'])
			@include('sidebar/antrian')
		@endrole
		@role(['admission','administrator'])
			@include('sidebar/tppri')
		@endrole
		@role(['rekammedis', 'supervisor-rekammedis','supervisor','administrator'])
			@include('sidebar/frontoffice')
		@endrole
		@role(['tracer','administrator'])
			@include('sidebar/tracer')
		@endrole
		@role(['outguide','administrator'])
			@include('sidebar/outguide')
		@endrole
		@role(['rawatdarurat','administrator'])
			@include('sidebar/igd')
		@endrole
		@role(['rawatjalan','administrator','dokter','adminpoli'])
			@include('sidebar/rawatjalan')
		@endrole
		@role(['rawatinap','administrator'])
			@include('sidebar/rawatinap')
		@endrole
		@role(['laboratorium','administrator'])
			@include('sidebar/laboratorium')
		@endrole
		@role(['radiologi','administrator'])
			@include('sidebar/radiologi')
		@endrole
		@role(['fisioterapi','administrator'])
			@include('sidebar/fisioterapi')
		@endrole
		@role(['kamarbersalin','administrator'])
			@include('sidebar/kamarbersalin')
		@endrole
		@role(['gizi','administrator'])
			@include('sidebar/gizi')
		@endrole
		@role(['operasi','administrator'])
			@include('sidebar/operasi')
		@endrole
		@role(['apotik', 'supervisor-apotik','supervisor','administrator'])
			@include('sidebar/farmasi')
		@endrole
		@role(['rawatjalan', 'rawatinap','rawatdarurat','laboratorium','operasi','radiologi','kamarbersalin','gizi','rekammedis','administrator'])
			@include('sidebar/depo')
		@endrole
		@role(['fisioterapi','gizi','apotik', 'supervisor-apotik','rawatjalan', 'rawatinap','rawatdarurat','laboratorium','operasi','radiologi','kamarbersalin','rekammedis','administrator'])
			@include('sidebar/inv')
		@endrole
		@role(['rawatjalan', 'rawatinap','rawatdarurat','fisioterapi','laboratorium','operasi','radiologi','kamarbersalin','administrator'])
			@include('sidebar/tariftindakan')
		@endrole
		@role(['kasir', 'supervisor', 'administrator'])
			@include('sidebar/kasir')
		@endrole
		@role(['display','admission','rawatinap','rawatdarurat','rawatjalan','supervisor','administrator'])
			@include('sidebar/informasi')
		@endrole
		{{-- @role(['cetak', 'supervisor','administrator'])
			@include('sidebar/cetak')
		@endrole --}}
	</ul>
	<!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
