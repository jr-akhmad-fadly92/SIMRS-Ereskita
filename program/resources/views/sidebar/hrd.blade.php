<li class="treeview {{ Auth::user()->role()->first()->name!='administrator' }}">
	<a href="#">
		<i class="fa fa-user-o text-grey-google"></i>
		<span>Managemen</span>
		<span class="pull-right-container">
			<i class="fa fa-angle-left pull-right"></i>
		</span>
	</a>
	<ul class="treeview-menu">
		<li>
		<a href="/managemen/kepegawaian">
				<i class="fa fa-user"></i> <span>Kepegawaian</span>
				
				</a>
				
		</li>
	</ul>
</li>