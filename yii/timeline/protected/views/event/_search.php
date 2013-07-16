<?php
/* @var $this EventController */
/* @var $model Event */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'text'); ?>
		<?php echo $form->textField($model,'text',array('size'=>60,'maxlength'=>5000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>500)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date_month'); ?>
		<?php echo $form->textField($model,'start_date_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_date_time'); ?>
		<?php echo $form->textField($model,'end_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_date_period'); ?>
		<?php echo $form->textField($model,'end_date_period'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_date_day'); ?>
		<?php echo $form->textField($model,'end_date_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_date_month'); ?>
		<?php echo $form->textField($model,'end_date_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_date_year'); ?>
		<?php echo $form->textField($model,'end_date_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date_time'); ?>
		<?php echo $form->textField($model,'start_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date_period'); ?>
		<?php echo $form->textField($model,'start_date_period'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date_day'); ?>
		<?php echo $form->textField($model,'start_date_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date_year'); ?>
		<?php echo $form->textField($model,'start_date_year'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->