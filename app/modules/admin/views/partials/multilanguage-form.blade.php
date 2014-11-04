<div class="col-xs-12">
	<ul class="nav nav-tabs">
		<?php
			$active = 'active';
			if(!empty($langs)){
				foreach($langs as $code => $lang){
					?>
	  <li class="{{ $active }}"><a href="#{{ $code }}-area-content" data-toggle="tab">{{ $lang }}</a></li>
	  			<?php
	  			$active = '';
	  		}
	  	}
		?>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<?php
			$active = 'active';
			if(!empty($langs)){
				foreach($langs as $code => $lang){
					?>
	  <div class="tab-pane {{ $active }}" id="{{ $code }}-area-content">
	  	<?php
	  		if(!empty($items)){
	  			foreach($items as $item){
	  				?>
  		{{ Form::label($item['name'], $item['title'], array('class' => 'col-xs-12 control-label pull-left')) }}
	  	<div class="col-xs-12">	  		
	  		{{ Form::{$item['type']}('multilanguage_' . $code . '_' . $item['name'] . '', null, array('class' => 'form-control', 'placeholder' => $item['title'])) }}
	  		<span class="error">{{ @$error_messages['multilanguage_' . $code . '_' . $item['name']][0] }}</span>
	  	</div>
	  				<?php
	  			}
	  		}
	  	?>
	  </div>
	  			<?php
	  			$active = '';
	  		}
	  	}
	  ?>
	</div>
</div>