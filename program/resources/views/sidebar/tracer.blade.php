<li class="treeview {{ Auth::user()->role()->first()->name!='administrator'  }}">
	<a href="#">
		<i class="fa fa-file text-grey-google"></i>
		<span>Tracert Dokumen RM</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li><a href="{{ url('frontoffice/tracerAll') }}"><i class="fa fa-print"></i> <span>Cetak Tracer </span></a></li>
		<li><a href="{{ url('frontoffice/tracer') }}"><i class="fa fa-print"></i> <span>Tracer</span></a></li>
		<li><a href="{{ url('frontoffice/data-sep') }}"><i class="fa fa-print"></i> <span>Cetak SEP</span></a></li>
		<li><a href="{{ url('frontoffice/data-sep2') }}"><i class="fa fa-print"></i> <span>Cetak SEP 2</span></a></li>
		<li><a href="{{ url('frontoffice/cetak_barcode/') }}"><i class="fa fa-print"></i> <span>Cetak Label Barcode</span></a></li>
		<li><a href="{{ url('frontoffice/outgate') }}"><i class="fa fa-file"></i> <span>Out Gate</span></a></li>
	</ul>
</li>