<?php
/* @var $this GroupController */
/* @var $model Group */

$this->breadcrumbs=array(
	'Groups'=>array('index'),
	$model->name=>array('view','id'=>$model->groupid),
	'Update',
);

$this->menu=array(
	// array('label'=>'List Group', 'url'=>array('index')),
	array('label'=>'新增', 'url'=>array('create')),
	array('label'=>'瀏覽Group', 'url'=>array('view', 'id'=>$model->groupid)),
	array('label'=>'管理Group', 'url'=>array('admin')),
);
?>

<h1>Update Group <?php echo $model->groupid; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>