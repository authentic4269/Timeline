<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Register';
$this->breadcrumbs=array(
        'Register',
);
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
        'id'=>'register-form',
        'enableAjaxValidation'=>true,
)); 
?>
<body>
<div class="container">
        <section id="content">
                <form action=""> 
                        <h1>Register</h1>
                        <div>
                                <?php echo $form->labelEx($model, 'username'); ?>
                                <?php echo $form->textField($model, 'username'); ?>
                                <?php echo $form->error($model,'username'); ?>
                        </div> 
                        <div>
                                <?php echo $form->labelEx($model, 'First Name'); ?>
                                <?php echo $form->textField($model, 'first_name'); ?>
                                <?php echo $form->error($model,'first_name'); ?>
                        </div> 
                        <div>
                                <?php echo $form->labelEx($model, 'Last Name'); ?>
                                <?php echo $form->textField($model, 'last_name'); ?>
                                <?php echo $form->error($model,'last_name'); ?>
                        </div> 
                        <div>
                                <?php echo $form->labelEx($model, 'email'); ?>
                                <?php echo $form->textField($model, 'email'); ?>
                                <?php echo $form->error($model,'email'); ?>
                        </div> 
                        <div>
                                <?php echo $form->labelEx($model,'Password'); ?>
                                <?php echo $form->passwordField($model,'pass'); ?>
                                <?php echo $form->error($model,'pass'); ?>
                        </div> 
                        <div>
                                <?php echo $form->labelEx($model,'Repeat Password'); ?>
                                <?php echo $form->passwordField($model,'repass'); ?>
                                <?php echo $form->error($model,'repass'); ?>
                        </div>
			<div>
				<input type="submit" value="Register" />
			</div>
                </form>
<?php $this->endWidget(); ?>
        </section><!-- content -->
</div><!-- container -->
</body>
</html>
