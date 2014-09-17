<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	'組織'=>array('index'),
	'管理',
);

$this->menu=array(
	array('label'=>'List Group', 'url'=>array('index')),
	array('label'=>'新增', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#group-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>管理組織</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('進階搜尋','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'group-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'groupid',
			'value'=>'$data->groupid',
			'htmlOptions' => array('style'=>'width:40px;')
			),

		array(
			'name'=>'name',
			'value'=>'$data->name',
			'htmlOptions' => array('style'=>'width:230px;')
			),

		'description',
		array(
			'name'=>'type',
			'value'=>'$data->type',
			'htmlOptions' => array('style'=>'width:80px;')
			),
		array(
			'class'=>'CButtonColumn',
			'htmlOptions' => array('style'=>'width:70px;')
		),
	),
)); ?>
