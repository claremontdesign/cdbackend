<?php if(!empty($widgets)): ?>
	<?php foreach ($widgets as $widget): ?>
		{!! cd_widget($widget) !!}
	<?php endforeach; ?>
<?php endif; ?>