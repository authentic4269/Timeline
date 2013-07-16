<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'Login',
);
ini_set("error_reporting", E_ALL | E_STRICT);
?>


<html>
<!--[if lt IE 7 ]> <html lang="en" class="ie6 ielt8"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="ie7 ielt8"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="ie8"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<title>Timeline</title>
<link rel="stylesheet" type="text/css" href="/css/login.css" />
</head>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'login-form',
        'enableAjaxValidation'=>true,
)); ?>
<body>
<div class="container">
	<section id="content">
		<form action="">
			<h1>Login</h1>
			<div>
				<?php echo $form->labelEx($model, 'username'); ?>
				<?php echo $form->textField($model, 'username'); ?>
		                <?php echo $form->error($model,'username'); ?>
			</div>
			<div>
                		<?php echo $form->labelEx($model,'password'); ?>
        		        <?php echo $form->passwordField($model,'password'); ?>
		                <?php echo $form->error($model,'password'); ?>
			</div>
			<div>
				<input type="submit" value="Log in" />
				<a href="forgotpass">Lost your password?</a>
				<a href="register">Register</a>
			</div>
		</form><!-- form -->
<?php $this->endWidget(); ?>
	</section><!-- content -->
</div><!-- container -->
</body>
</html>
