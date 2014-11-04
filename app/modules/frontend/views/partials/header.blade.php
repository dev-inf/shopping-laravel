<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button data-target="#collapse-top" data-toggle="collapse" class="navbar-toggle" type="button">
				<span class="sr-only">Top menu</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">New Film</a>
		</div>
		<div class="collapse navbar-collapse" id="collapse-top">
			<ul class="nav navbar-nav">
				<li><a href="#">Giới thiệu</a></li>
				<li><a href="#">Hướng dẫn</a></li>
				<li><a href="#">Liên lạc</a></li>
				<li><a href="#">Yêu cầu phim</a></li>
				<li><a href="#">Xếp hạng</a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<?php if(!Auth::admin()->guest()){ ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b><i class="glyphicon glyphicon-user"></i>&nbsp;Hà Phan Minh</a>
					<ul class="dropdown-menu">
						<li><a href="#">Bạn đang có 0.000 xu</a></li>
						<li><a href="#">Nạp thêm xu</a></li>
						<li><a href="#">Thông tin cá nhân</a></li>
						<li><a href="#">Lịch sử</a></li>
						<li class="divider"></li>
						<li><a href="#">Thoát</a></li>
					</ul>
				</li>
				<?php }else{ ?>
				<li class="dropdown" id="login">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="caret"></b>&nbsp;Đăng nhập&nbsp;</a>/<a href="#">Đăng ký</a>
					<div class="row dropdown-menu">
						<div class="col-xs-12">
							<form class="form-inline" role="form">
								<div class="col-xs-12 error"></divĐ
								<div class="form-group">
									<label class="sr-only" for="email">Email</label>
									<input type="email" class="form-control" id="email" placeholder="Email">
								</div>
								<div class="form-group">
									<label class="sr-only" for="password">Mật Khẩu</label>
									<input type="password" class="form-control" id="password" placeholder="Mật Khẩu">
								</div>
								<button type="submit" class="btn btn-primary login">Đăng nhập</button>
							</form>
							<ul class="list-inline">
								<li class="facebook"><a href="#"></a></li>
								<li class="google"><a href="#"></a></li>
								<li class="twitter"><a href="#"></a></li>
							</ul>
						</div>
					</div>
				</li>
				<?php } ?>
			</ul>
			<form class="navbar-form navbar-right" role="search">
				<div class="form-group has-feedback">
					<input type="text" class="form-control" id="inputQuickSearch">
					<span class="glyphicon glyphicon-search form-control-feedback"></span>
				</div>
			</form>
		</div>
	</div>
</nav>