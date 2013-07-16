<?php
/* @var $this EventController */
/* @var $model Event */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'event-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php echo $form->textField($model,'text',array('size'=>60,'maxlength'=>5000)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date_month'); ?>
		<?php echo $form->textField($model,'start_date_month'); ?>
		<?php echo $form->error($model,'start_date_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date_time'); ?>
		<?php echo $form->textField($model,'end_date_time'); ?>
		<?php echo $form->error($model,'end_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date_period'); ?>
		<?php echo $form->textField($model,'end_date_period'); ?>
		<?php echo $form->error($model,'end_date_period'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date_day'); ?>
		<?php echo $form->textField($model,'end_date_day'); ?>
		<?php echo $form->error($model,'end_date_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date_month'); ?>
		<?php echo $form->textField($model,'end_date_month'); ?>
		<?php echo $form->error($model,'end_date_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date_year'); ?>
		<?php echo $form->textField($model,'end_date_year'); ?>
		<?php echo $form->error($model,'end_date_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date_time'); ?>
		<?php echo $form->textField($model,'start_date_time'); ?>
		<?php echo $form->error($model,'start_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date_period'); ?>
		<?php echo $form->textField($model,'start_date_period'); ?>
		<?php echo $form->error($model,'start_date_period'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date_day'); ?>
		<?php echo $form->textField($model,'start_date_day'); ?>
		<?php echo $form->error($model,'start_date_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date_year'); ?>
		<?php echo $form->textField($model,'start_date_year'); ?>
		<?php echo $form->error($model,'start_date_year'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->