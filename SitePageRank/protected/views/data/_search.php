<?php
/* @var $this DataController */
/* @var $model Data */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'DataID'); ?>
		<?php echo $form->textField($model,'DataID',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'SiteID'); ?>
		<?php echo $form->textField($model,'SiteID'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'GoogleData'); ?>
		<?php echo $form->textField($model,'GoogleData',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'Time'); ?>
		<?php echo $form->textField($model,'Time'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'YY'); ?>
		<?php echo $form->textField($model,'YY'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'MM'); ?>
		<?php echo $form->textField($model,'MM'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'DD'); ?>
		<?php echo $form->textField($model,'DD'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->