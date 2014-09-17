<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	'組織'=>array('index'),
	'新增',
);

$this->menu=array(
	array('label'=>'管理', 'url'=>array('admin')),
);
?>

<h1>新增群組</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>