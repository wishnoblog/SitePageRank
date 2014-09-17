<?php
/* @var $this TblUserController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tbl Users',
);

$this->menu=array(
	array('label'=>'Create TblUser', 'url'=>array('create')),
	array('label'=>'Manage TblUser', 'url'=>array('admin')),
);
?>

<h1>Tbl Users</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
