<?php
/* @var $this GroupController */
/* @var $data Group */
?>

	<td>
	<b><?php echo CHtml::encode($data->getAttributeLabel('groupid')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->groupid), array('view', 'id'=>$data->groupid)); ?>
	<br />
	</td>
	<td>
	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />
	</td>
	<td>
	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />
	</td>
	<td>
	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	</td>
	<br />