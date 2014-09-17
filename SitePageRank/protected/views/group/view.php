<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	'組織'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Group', 'url'=>array('index')),
	array('label'=>'新增單位', 'url'=>array('create')),
	array('label'=>'更新單位', 'url'=>array('update', 'id'=>$model->groupid)),
	array('label'=>'刪除', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->groupid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'管理組織', 'url'=>array('admin')),
);
?>

<h1>View Group #<?php echo $model->groupid; ?></h1>
		
		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'groupid',
				'name',
				'description',
				'type',
			),
		)); ?>

