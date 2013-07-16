<?php
/* @var $this EventController */
/* @var $data Event */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
	<?php echo CHtml::encode($data->text); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date_month')); ?>:</b>
	<?php echo CHtml::encode($data->start_date_month); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date_time')); ?>:</b>
	<?php echo CHtml::encode($data->end_date_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date_period')); ?>:</b>
	<?php echo CHtml::encode($data->end_date_period); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date_day')); ?>:</b>
	<?php echo CHtml::encode($data->end_date_day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date_month')); ?>:</b>
	<?php echo CHtml::encode($data->end_date_month); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date_year')); ?>:</b>
	<?php echo CHtml::encode($data->end_date_year); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date_time')); ?>:</b>
	<?php echo CHtml::encode($data->start_date_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date_period')); ?>:</b>
	<?php echo CHtml::encode($data->start_date_period); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date_day')); ?>:</b>
	<?php echo CHtml::encode($data->start_date_day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date_year')); ?>:</b>
	<?php echo CHtml::encode($data->start_date_year); ?>
	<br />

	*/ ?>

</div>