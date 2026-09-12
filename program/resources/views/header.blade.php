<a href="" class="logo" style="background-color:white!important;">
  <span class="logo-mini"><img src="{{ asset('public/images/logo-ereskita.png') }}" style="width:40px;margin-top:4px;"></span>
  <span class="logo-lg"><img src="{{ asset('public/images/logo-ereskita.png') }}" style="width:40px;margin-top:-4px;"> Ereskita</span>
</a>
<nav class="navbar navbar-static-top">
  <div style="font-size: 15pt; float: left; margin-top: 10px; margin-left: 20px; letter-spacing: 0">
      @php $config = Modules\Config\Entities\Config::find(1);
      @endphp
      {{ $config->nama }}
  </div>
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
			<li class="dropdown notifications-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="border:none;">
					<i class="fa fa-bell text-orange" style="line-height:1.4777;font-size:13px;"></i>
					<span id="count-notif" class="label label-danger" style="display:none;font-size:11px;font-weight:600;padding:3px;">0</span>
				</a>
				<ul class="dropdown-menu">
					<li>
						<ul id="list-notif" class="menu">
							<li id="no-notif">
								<a href="#">
									<span class="text12">Belum ada notifikasi</span>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</li>
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-user text-grey-google" style="font-size:15px;color:#40c4ff;"></i>
          <span class="hidden-xs">{{ (Auth::guest()) ? '' : Auth::user()->name }}</span>
        </a>

        <ul class="dropdown-menu" style="background:transparent!important;border:none!important;right:0!important;">
          <!-- User image -->
          <li class="user-header">
            <p><b>{{ (Auth::guest()) ? '' : Auth::user()->name }}</b></p>
            <p>
              <small>Masuk Sejak : {{ (Auth::guest()) ? '' : Auth::user()->created_at->diffForHumans() }}</small>
            </p>
          </li>

          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="{{ (Auth::guest()) ? '' : route('user.show', Auth::user()->id) }}" class="btn btn-default btn-flat">Ubah Kata Sandi</a>
            </div>
            <div class="pull-right">
              <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
								Keluar 
							</a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>