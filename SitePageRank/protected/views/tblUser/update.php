<?php
/* @var $this TblUserController */
/* @var $model TblUser */

$this->breadcrumbs=array(
	'Tbl Users'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TblUser', 'url'=>array('index')),
	array('label'=>'Create TblUser', 'url'=>array('create')),
	array('label'=>'View TblUser', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TblUser', 'url'=>array('admin')),
);
?>

<h1>Update TblUser <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>