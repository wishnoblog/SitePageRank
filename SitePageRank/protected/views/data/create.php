<?php
/* @var $this DataController */
/* @var $model Data */

$this->breadcrumbs=array(
	'Datas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Data', 'url'=>array('index')),
	array('label'=>'Manage Data', 'url'=>array('admin')),
);
?>

<h1>Create Data</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>