<div class="container">
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
			@include('frontend::block.list-footer', ['list' => 1, 'title' => 'Phim lẻ mới nhất', 'data' => \Films::getInfoFooter('movie',5)])
		</div>
		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
			@include('frontend::block.list-footer', ['list' => 1, 'title' => 'Phim bộ mới nhất', 'data' => \Films::getInfoFooter('drama',5)])
		</div> 
		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
			@include('frontend::block.list-footer', ['list' => 1, 'title' => 'Top 5 diễn viên', 'data' => \Films::getInfoFooter('cast',5)])
		</div>
		<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
			@include('frontend::block.list-footer', ['list' => 0, 'title' => 'Văn phòng'])
		</div>
	</div>
</div><!-- /.container -->  
<nav role="navigation" class="navbar navbar-default">
	<div class="container">
		  <!-- Brand and toggle get grouped for better mobile display -->
		  <div class="navbar-header">
			<a href="#" class="navbar-brand">New Film</a>
		  </div>
		<ul class="nav navbar-nav navbar-right">
			<li>	
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">Theo dõi!</button>
					</span>
					<input type="text" class="form-control" placeholder="Địa chỉ Email">
				</div><!-- /input-group -->
			</li>
		</ul>
	</div><!-- /.container -->
</nav>