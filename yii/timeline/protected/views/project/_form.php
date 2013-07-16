<?php
/* @var $this ProjectController */
/* @var $model Project */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'project-form',
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
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>1024)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'short_link'); ?>
		<?php echo $form->textField($model,'short_link',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'short_link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date_year'); ?>
		<?php echo $form->textField($model,'start_date_year'); ?>
		<?php echo $form->error($model,'start_date_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date_month'); ?>
		<?php echo $form->textField($model,'start_date_month'); ?>
		<?php echo $form->error($model,'start_date_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date_day'); ?>
		<?php echo $form->textField($model,'start_date_day'); ?>
		<?php echo $form->error($model,'start_date_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date_period'); ?>
		<?php echo $form->textField($model,'start_date_period'); ?>
		<?php echo $form->error($model,'start_date_period'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date_time'); ?>
		<?php echo $form->textField($model,'start_date_time'); ?>
		<?php echo $form->error($model,'start_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date_year'); ?>
		<?php echo $form->textField($model,'end_date_year'); ?>
		<?php echo $form->error($model,'end_date_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date_month'); ?>
		<?php echo $form->textField($model,'end_date_month'); ?>
		<?php echo $form->error($model,'end_date_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date_day'); ?>
		<?php echo $form->textField($model,'end_date_day'); ?>
		<?php echo $form->error($model,'end_date_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date_period'); ?>
		<?php echo $form->textField($model,'end_date_period'); ?>
		<?php echo $form->error($model,'end_date_period'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date_time'); ?>
		<?php echo $form->textField($model,'end_date_time'); ?>
		<?php echo $form->error($model,'end_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>5000)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'language'); ?>
		<?php echo $form->textField($model,'language',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'language'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_modified'); ?>
		<?php echo $form->textField($model,'last_modified'); ?>
		<?php echo $form->error($model,'last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
		<?php echo $form->textField($model,'category_id'); ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textField($model,'tags',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'tags'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mix_licence_id'); ?>
		<?php echo $form->textField($model,'mix_licence_id'); ?>
		<?php echo $form->error($model,'mix_licence_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'age_rating_id'); ?>
		<?php echo $form->textField($model,'age_rating_id'); ?>
		<?php echo $form->error($model,'age_rating_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'learning_level_id'); ?>
		<?php echo $form->textField($model,'learning_level_id'); ?>
		<?php echo $form->error($model,'learning_level_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'views_id'); ?>
		<?php echo $form->textField($model,'views_id'); ?>
		<?php echo $form->error($model,'views_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'grade'); ?>
		<?php echo $form->textField($model,'grade'); ?>
		<?php echo $form->error($model,'grade'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'flag_id'); ?>
		<?php echo $form->textField($model,'flag_id'); ?>
		<?php echo $form->error($model,'flag_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'folder_id'); ?>
		<?php echo $form->textField($model,'folder_id'); ?>
		<?php echo $form->error($model,'folder_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'calendar_id'); ?>
		<?php echo $form->textField($model,'calendar_id'); ?>
		<?php echo $form->error($model,'calendar_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->