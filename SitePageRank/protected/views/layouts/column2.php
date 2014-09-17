<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="container-fluid">
	<div class="col-md-10"><?php echo $content; ?></div>
	 <div class="col-md-2">
	 	<h3>
	 	<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'操作',
			));
			?>
				</h3>

			<?php
			$this->widget('zii.widgets.CMenu', array(
				
				//'itemOptions'=>array('class'=>'visited'),
				'items'=>$this->menu,
				'htmlOptions'=>array('class'=>'list-group-item'),
			));
			$this->endWidget();
		?>
	</div>
  	
</div>
<?php $this->endContent(); ?>