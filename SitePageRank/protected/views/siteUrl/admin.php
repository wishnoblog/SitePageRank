<?php
/* @var $this SiteUrlController */
/* @var $model SiteUrl */

$this->breadcrumbs=array(
	'網站網址'=>array('index'),
	'管理',
);

$this->menu=array(
	array('label'=>'列出網址', 'url'=>array('index')),
	array('label'=>'新增', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#site-url-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理網址</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'site-url-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
		'name'=>'SiteID',
		'value'=>'$data->SiteID',
		'htmlOptions' => array('style'=>'width:40px;')
		),
		
		'name',
		'site',
		array(
		    'name' => 'groupid',
		    'value'=>'$data->siteType->name',
		    'filter'=>CHtml::activeDropDownList($model,'groupid', CHtml::listData(Group::model()->findAll(), 'groupid', 'name')),
		),
		array(
		    //'name' => 'siteType->type',
		    'value'=>'$data->siteType->type',
		    //'filter'=>CHtml::activeDropDownList($model,'groupid', CHtml::listData(Group::model()->findAll(), 'groupid', 'name')),
		),
		array(
		'name'=>'Enable',
		'value'=>'$data->Enable',
		'htmlOptions' => array('style'=>'width:40px;')
		),
		array(

			'class'=>'CButtonColumn',
			'htmlOptions' => array('style'=>'width:70px;')
		),
	),
)); ?>
