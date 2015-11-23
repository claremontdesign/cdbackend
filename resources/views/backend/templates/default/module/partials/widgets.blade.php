<?php if(!empty($widgets)): ?>
	<?php foreach ($widgets as $widget): ?>
		{!! cd_widget($widget, $controller, $module) !!}
	<?php endforeach; ?>
<?php endif; ?>