<?php
/* @var $this DataController */
/* @var $model Data */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'data-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'SiteID'); ?>
		<?php echo $form->textField($model,'SiteID'); ?>
		<?php echo $form->error($model,'SiteID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'GoogleData'); ?>
		<?php echo $form->textField($model,'GoogleData',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'GoogleData'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Time'); ?>
		<?php echo $form->textField($model,'Time'); ?>
		<?php echo $form->error($model,'Time'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'YY'); ?>
		<?php echo $form->textField($model,'YY'); ?>
		<?php echo $form->error($model,'YY'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'MM'); ?>
		<?php echo $form->textField($model,'MM'); ?>
		<?php echo $form->error($model,'MM'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'DD'); ?>
		<?php echo $form->textField($model,'DD'); ?>
		<?php echo $form->error($model,'DD'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->