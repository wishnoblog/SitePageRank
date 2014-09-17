<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $this->pageTitle ?></title>
		<!-- bootstarp css -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl ?>/css/bootstrap.min.css" />
		<!-- font-awesome css -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl ?>/css/font-awesome.min.css" />
		<!-- jquery core js -->
		<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery-1.11.0.js"></script>
		<!-- bootstarp core js -->
		<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/bootstrap.min.js"></script>
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
						'items'=>array(
							array('label'=>'說明', 'url'=>array('/site/index')),
							array('label'=>'Rank', 'url'=>array('#')),
							array('label'=>'網址', 'url'=>array('/siteurl', 'view'=>'about')),
							array('label'=>'提升網站能見度', 'url'=>array('')),

							array('label'=>Yii::app()->params['schoolName'], 'url'=>Yii::app()->params['schoolURL'],'linkOptions' => array('target'=>'_blank'), ),

							array('label'=>'管理登入', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
							array('label'=>'登出 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'組織', 'url'=>array('/group/'), 'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'網址', 'url'=>array('/siteurl/'), 'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'記錄查詢', 'url'=>array('#'), 'visible'=>!Yii::app()->user->isGuest),
						),
					)); ?>
					</div><!--/.nav-collapse -->
				</div>
			</div>
			<div  class="container">
				<?php if(isset($this->breadcrumbs)):?>
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
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