<?php
/* @var $this SiteUrlController */
/* @var $model SiteUrl */

$this->breadcrumbs=array(
	'網址'=>array('index'),
	'新增',
);

$this->menu=array(
	array('label'=>'列出網址', 'url'=>array('index'),'itemOptions' => array('class'=>'list-group-item'),),
	array('label'=>'管理網址', 'url'=>array('admin'),'itemOptions' => array('class'=>'list-group-item'),),
);
?>

<h1>新增網址</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>