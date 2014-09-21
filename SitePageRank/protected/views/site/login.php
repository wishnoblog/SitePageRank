<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	'登入',
);
?>

<h1>系統管理登入</h1>

<p></p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username', array('class'=>'form-control','placeholder'=>'帳號')); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password',array('class'=>'form-control','placeholder'=>'密碼')); ?>
		<?php echo $form->error($model,'password'); ?>

	</div>

	<div class="checkbox">
	<label>
		<?php echo $form->checkBox($model,'rememberMe'); ?>記住
	</label>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons form-group">
		<?php echo CHtml::submitButton('登入',array('class'=>'btn btn-primary btn-lg','encode' => false,)); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
