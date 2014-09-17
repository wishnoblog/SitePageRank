<?php
/* @var $this DataController */
/* @var $data Data */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('DataID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->DataID), array('view', 'id'=>$data->DataID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('SiteID')); ?>:</b>
	<?php echo CHtml::encode($data->SiteID); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('GoogleData')); ?>:</b>
	<?php echo CHtml::encode($data->GoogleData); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Time')); ?>:</b>
	<?php echo CHtml::encode($data->Time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('YY')); ?>:</b>
	<?php echo CHtml::encode($data->YY); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('MM')); ?>:</b>
	<?php echo CHtml::encode($data->MM); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('DD')); ?>:</b>
	<?php echo CHtml::encode($data->DD); ?>
	<br />


</div>