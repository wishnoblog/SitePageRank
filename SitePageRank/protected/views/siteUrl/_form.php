<?php
/* @var $this SiteUrlController */
/* @var $model SiteUrl */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'site-url-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'site'); ?>
		<?php echo $form->textField($model,'site',array('size'=>60,'maxlength'=>400)); ?>
		<?php echo $form->error($model,'site'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'groupid'); ?>
		<?php echo $form->dropDownList($model,'groupid', CHtml::listData(Group::model()->findAll(), 'groupid', 'name'), array('empty'=>'選擇類型')); ?>

		<?php //echo $form->textField($model,'groupid'); ?>
		<?php echo CHtml::link('新增類型',array('group/create')); ?>
		<?php echo $form->error($model,'groupid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Enable'); ?>
		<?php echo $form->textField($model,'Enable'); ?>
		<?php echo $form->error($model,'Enable'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '新增' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->