<?php
/* @var $this SiteUrlController */
/* @var $data SiteUrl */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('SiteID')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->SiteID), array('view', 'id'=>$data->SiteID)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('site')); ?>:</b>
	<?php echo CHtml::encode($data->site); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('groupid')); ?>:</b>
	<?php echo CHtml::encode($data->siteType->name); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('Enable')); ?>:</b>
	<?php echo CHtml::encode($data->Enable); ?>
	<br />


</div>