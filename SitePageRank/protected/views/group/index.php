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
<table class="table table-hover">
	  <thead>
		<tr>
		<th>#</th>
			<th>#</th>
			<th>組織</th>
			<th>類型</th>
			<th>說明</th>
		</tr>
	</thead>	
	<tbody>

	</tbody>
</table>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		'groupid',
		'name',
		'description',
		'type',
		)
)); ?>
