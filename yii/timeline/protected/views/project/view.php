<?php
/* @var $this ProjectController */
/* @var $model Project */

$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Project', 'url'=>array('index')),
	array('label'=>'Create Project', 'url'=>array('create')),
	array('label'=>'Update Project', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Project', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Project', 'url'=>array('admin')),
);
?>

<h1>View Project #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'user_id',
		'link',
		'short_link',
		'start_date_year',
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
	),
)); ?>
