<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Filter</h3>
	</div>
	<div class="panel-body">
		<form id="filter-form">
			<table class="table table-filter">
				<tr>
					<?php
					if (@$items != '') {
						foreach ($items as $item) {
							if (@$item['type'] == 'number') {
								?>
								<th>
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ $item['title'] }} <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<div class="input-group">
											<input type="hidden" name="filter[{{ $item['name'] }}][0][op]" value="{{ htmlentities('>=') }}">
											<span class="input-group-addon">&gt;=</span> <input type="text" class="form-control" name="filter[{{ $item['name'] }}][0][value]" placeholder="">
										</div>
									</li>
									<li>
										<div class="input-group">
											<input type="hidden" name="filter[{{ $item['name'] }}][1][op]" value="=">
											<span class="input-group-addon">=</span> <input type="text" class="form-control" name="filter[{{ $item['name'] }}][1][value]" placeholder="">
										</div>
									</li>
									<li>
										<div class="input-group">
											<input type="hidden" name="filter[{{ $item['name'] }}][2][op]" value="{{ htmlentities('<=') }}">
											<span class="input-group-addon">&lt;=</span> <input type="text" class="form-control" name="filter[{{ $item['name'] }}][2][value]" placeholder="">
										</div>
									</li>
								</ul>
							</div>
							</th>
							<?php
						} elseif (@$item['type'] == 'checkbox') {
							?>

							<th>
							<div class="btn-group">
								<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">{{ $item['title'] }} <span class="caret"></span>
								</button>
								<input type="hidden" name="filter[{{ $item['name'] }}][op]" value="IN">
								<ul class="dropdown-menu " role="menu">
									<?php
									if (@$item['options'] != '') {
										foreach ($item['options'] as $value => $option) {
											?>
											<li class="checkbox-filter">
												<div class="col-lg-12 checkbox">
													<label><input type="checkbox" value="{{ $value }}" name="filter[{{ $item['name'] }}][value][{{ $value }}]"> {{ $option }}</label>
												</div>
											</li>
											<?php
										}
									}
									?>
								</ul>
							</div>
							</th>

							<?php
						} else {
							?>

							<th>
								<input type="hidden" name="filter[{{ $item['name'] }}][op]" value="{{ isset($item['op']) ? $item['op'] : '=' }}">
								<input type="text" name="filter[{{ $item['name'] }}][value]" placeholder="{{ @$item['placeholder'] }}" class="form-control">
							</th>

							<?php
						}
					}
				}
				?>
				<th>
					<button id="submit-filter" class="btn btn-info glyphicon glyphicon-filter" type="button"></button>
				</th>
				</tr>
			</table>
		</form>
	</div>
</div>