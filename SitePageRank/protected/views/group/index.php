<?php
/* @var $this GroupController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'組織',
);

$this->menu=array(
	array('label'=>'管理', 'url'=>array('admin')),
	array('label'=>'新增', 'url'=>array('create')),
	
);
?>

<h1>組織</h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'groupid',
		'name',
		'description',
		'type',
		)
)); ?>
