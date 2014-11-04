<nav class="navbar navbar-fixed-top">
	<ul class="list-inline navbar-right">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-messages">
				<li>
					<a href="#">
						<div>
							<strong>{{ \Auth::admin()->user()->username }}</strong>
							<span class="text-muted">
								<em>Yesterday</em>
							</span>
						</div>
						<div>Ba là cây nến vàng ...</div>
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="#">
						<div>
							<strong>{{ \Auth::admin()->user()->username }}</strong>
							<span class="text-muted">
								<em>Yesterday</em>
							</span>
						</div>
						<div>Mẹ là cây nến xanh ...</div>
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="#">
						<div>
							<strong>{{ \Auth::admin()->user()->username }}</strong>
							<span class="text-muted">
								<em>Yesterday</em>
							</span>
						</div>
						<div>Con là cây nến hồng ...</div>
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a class="text-center" href="#">
						<strong>Read All Messages</strong>
						<i class="fa fa-angle-right"></i>
					</a>
				</li>
			</ul>
			<!-- /.dropdown-messages -->
		</li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-user">
				<li><a href="{{ URL::to('admin/users/modify', \Auth::admin()->user()->id) }}"><i class="fa fa-user fa-fw"></i> User Profile</a>
				</li>
				<li><a href="{{ URL::to('admin/configuration/modify') }}"><i class="fa fa-gear fa-fw"></i> Settings</a>
				</li>
				<li class="divider"></li>
				<li><a href="{{ URL::route('logout') }}"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
				</li>
			</ul>
			<!-- /.dropdown-user -->
		</li>
		<!-- /.dropdown -->
	</ul>
</nav>