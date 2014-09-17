<?php
/* @var $this GroupController */
/* @var $model Group */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'group-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="form-group">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200,'class' => 'form-control','placeholder'=>'組織名稱，例如計網中心。')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

	<div class="row">
		<div class="form-group">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('rows'=>6, 'cols'=>50,'class' => 'form-control','placeholder'=>'對於這群組的說明')); ?>
		<?php echo $form->error($model,'description'); ?>
		</div>
	</div>

	<div class="row">
		<div class="form-group">
			<?php echo $form->labelEx($model,'type'); ?>
			<?php echo ZHtml::enumDropDownList( $model,'type',array('class' => 'form-control','placeholder'=>'對於這群組的說明')); ?>
			<?php echo $form->error($model,'type'); ?>
		</div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '新增' : 'Save',array("class"=>"btn btn-primary btn-large")
); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->