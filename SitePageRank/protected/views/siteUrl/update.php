<?php
/* @var $this SiteUrlController */
/* @var $model SiteUrl */

$this->breadcrumbs=array(
	'Site Urls'=>array('index'),
	$model->name=>array('view','id'=>$model->SiteID),
	'Update',
);

$this->menu=array(
	array('label'=>'List SiteUrl', 'url'=>array('index')),
	array('label'=>'Create SiteUrl', 'url'=>array('create')),
	array('label'=>'View SiteUrl', 'url'=>array('view', 'id'=>$model->SiteID)),
	array('label'=>'Manage SiteUrl', 'url'=>array('admin')),
);
?>

<h1>Update SiteUrl <?php echo $model->SiteID; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>