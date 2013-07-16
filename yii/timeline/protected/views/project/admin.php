<?php
/* @var $this ProjectController */
/* @var $model Project */

$this->breadcrumbs=array(
	'Projects'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Project', 'url'=>array('index')),
	array('label'=>'Create Project', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#project-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Projects</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'project-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'user_id',
		'link',
		'short_link',
		'start_date_year',
		/*
		'start_date_month',
		'start_date_day',
		'start_date_period',
		'start_date_time',
		'end_date_year',
		'end_date_month',
		'end_date_day',
		'end_date_period',
		'end_date_time',
		'description',
		'language',
		'created',
		'last_modified',
		'category_id',
		'tags',
		'mix_licence_id',
		'age_rating_id',
		'learning_level_id',
		'views_id',
		'grade',
		'flag_id',
		'folder_id',
		'calendar_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
