<?php
/* @var $this ProjectController */
/* @var $model Project */
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
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>1024)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'short_link'); ?>
		<?php echo $form->textField($model,'short_link',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date_year'); ?>
		<?php echo $form->textField($model,'start_date_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date_month'); ?>
		<?php echo $form->textField($model,'start_date_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date_day'); ?>
		<?php echo $form->textField($model,'start_date_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date_period'); ?>
		<?php echo $form->textField($model,'start_date_period'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date_time'); ?>
		<?php echo $form->textField($model,'start_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_date_year'); ?>
		<?php echo $form->textField($model,'end_date_year'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_date_month'); ?>
		<?php echo $form->textField($model,'end_date_month'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_date_day'); ?>
		<?php echo $form->textField($model,'end_date_day'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_date_period'); ?>
		<?php echo $form->textField($model,'end_date_period'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_date_time'); ?>
		<?php echo $form->textField($model,'end_date_time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>5000)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'language'); ?>
		<?php echo $form->textField($model,'language',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'last_modified'); ?>
		<?php echo $form->textField($model,'last_modified'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'category_id'); ?>
		<?php echo $form->textField($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tags'); ?>
		<?php echo $form->textField($model,'tags',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mix_licence_id'); ?>
		<?php echo $form->textField($model,'mix_licence_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'age_rating_id'); ?>
		<?php echo $form->textField($model,'age_rating_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'learning_level_id'); ?>
		<?php echo $form->textField($model,'learning_level_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'views_id'); ?>
		<?php echo $form->textField($model,'views_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'grade'); ?>
		<?php echo $form->textField($model,'grade'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'flag_id'); ?>
		<?php echo $form->textField($model,'flag_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'folder_id'); ?>
		<?php echo $form->textField($model,'folder_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'calendar_id'); ?>
		<?php echo $form->textField($model,'calendar_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->