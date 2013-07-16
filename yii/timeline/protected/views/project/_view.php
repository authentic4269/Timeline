<?php
/* @var $this ProjectController */
/* @var $data Project */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('short_link')); ?>:</b>
	<?php echo CHtml::encode($data->short_link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date_year')); ?>:</b>
	<?php echo CHtml::encode($data->start_date_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date_month')); ?>:</b>
	<?php echo CHtml::encode($data->start_date_month); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date_day')); ?>:</b>
	<?php echo CHtml::encode($data->start_date_day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date_period')); ?>:</b>
	<?php echo CHtml::encode($data->start_date_period); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date_time')); ?>:</b>
	<?php echo CHtml::encode($data->start_date_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date_year')); ?>:</b>
	<?php echo CHtml::encode($data->end_date_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date_month')); ?>:</b>
	<?php echo CHtml::encode($data->end_date_month); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date_day')); ?>:</b>
	<?php echo CHtml::encode($data->end_date_day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date_period')); ?>:</b>
	<?php echo CHtml::encode($data->end_date_period); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date_time')); ?>:</b>
	<?php echo CHtml::encode($data->end_date_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('language')); ?>:</b>
	<?php echo CHtml::encode($data->language); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_modified')); ?>:</b>
	<?php echo CHtml::encode($data->last_modified); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tags')); ?>:</b>
	<?php echo CHtml::encode($data->tags); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mix_licence_id')); ?>:</b>
	<?php echo CHtml::encode($data->mix_licence_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('age_rating_id')); ?>:</b>
	<?php echo CHtml::encode($data->age_rating_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('learning_level_id')); ?>:</b>
	<?php echo CHtml::encode($data->learning_level_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('views_id')); ?>:</b>
	<?php echo CHtml::encode($data->views_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('grade')); ?>:</b>
	<?php echo CHtml::encode($data->grade); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('flag_id')); ?>:</b>
	<?php echo CHtml::encode($data->flag_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('folder_id')); ?>:</b>
	<?php echo CHtml::encode($data->folder_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('calendar_id')); ?>:</b>
	<?php echo CHtml::encode($data->calendar_id); ?>
	<br />

	*/ ?>

</div>