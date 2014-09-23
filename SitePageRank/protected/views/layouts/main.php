<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $this->pageTitle ?></title>
		<!-- bootstarp css -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl ?>/css/bootstrap-table.css" />

		<!-- font-awesome css -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl ?>/css/font-awesome.min.css" />
		<!-- bootstarp core js -->
		<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/bootstrap-table.js"></script>


		<style type="text/css">
			body{
				padding-top: 60px;
			}
		</style>
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#"><?php echo Yii::app()->name ?></a>
				</div>
				<div class="collapse navbar-collapse">
					<?php $this->widget('zii.widgets.CMenu',array(
						'htmlOptions'=>array('class'=>'nav navbar-nav'),
						'encodeLabel'=>false,

						'items'=>array(
							array('label'=>'<i class="fa fa-globe"></i> 最新排名', 'url'=>array('/排名')),
							array('label'=>'<span class="glyphicon glyphicon-star"></span> 提升搜尋排名', 'url'=>array('/site/pagerank')),
							array('label'=>'<i class="fa fa-flag-o"></i> 提升網站能見度', 'url'=>array('/site/seo')),

							array('label'=>'<i class="fa fa-university"></i> '. Yii::app()->params['schoolName'], 'url'=>Yii::app()->params['schoolURL'],'linkOptions' => array('target'=>'_blank'), ),
						),
					)); ?>

					<?php $this->widget('zii.widgets.CMenu',array(
						'htmlOptions'=>array('class'=>'nav navbar-nav navbar-right'),
						'encodeLabel'=>false,
						'items'=>array(

							array('label'=>'<i class="fa fa-users"></i> 組織', 'url'=>array('/group/'), 'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'<i class="fa fa-tasks"></i> 網址', 'url'=>array('/siteurl/'), 'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'<i class="fa fa-floppy-o"></i> 手動執行', 'url'=>array('#'), 'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'<i class="fa fa-cog"></i>管理登入', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),							
							array('label'=>'登出 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
						),
					)); ?>

					 <ul class="nav navbar-nav navbar-right">
					 </ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
			<div  class="container">
				<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
					'htmlOptions'=>array ('class'=>'breadcrumb')
				)); ?><!-- breadcrumbs -->
				<?php endif?>
				<?php echo $content; ?>
				</div><!-- end container -->
				<hr>
				<div id="footer">
					<div align="center">

						Copyright &copy; <?php echo date('Y'); ?> by <a href="http://www.kuas.edu.tw">國立高雄應用科技大學</a>計算機與網路中心<br/>
						All Rights Reserved.<br/>程式設計 <a href="mailto:wishnoblog@gmail.com">歐陽毅 </a> GitHub
					</div>
					</div><!-- footer -->
				</body>
			</html>