<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- bootstarp css -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl ?>/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl ?>/css/bootstrap-table.css" />
		
		<!-- font-awesome css -->
		<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl ?>/css/font-awesome.min.css" />
		<!-- bootstarp core js -->



		<style type="text/css">

		</style>

		<title><?php echo $this->pageTitle ?></title>
		<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/bootstrap.min.js"></script>
		<script src="<?php echo Yii::app()->theme->baseUrl ?>/js/bootstrap-table.js"></script>

	</head>
	<body>
		<div class="navbar navbar-inverse navbar-static-top" role="navigation">
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
							array('label'=>'<i class="fa fa-globe"></i> 首頁', 'url'=>array('/'),'active'=>(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id)=='site/index',),
							array('label'=>'<i class="fa fa-university"></i> 行政單位排名', 'url'=>array('/行政單位排名'),'active'=>(Yii::app()->controller->id=='data' AND Yii::app()->controller->action->id=='RankOffice'),),
							array('label'=>'<i class="fa fa-graduation-cap"></i> 學術單位排名', 'url'=>array('/學術單位排名'),'active'=>(Yii::app()->controller->id=='data' AND Yii::app()->controller->action->id=='RankTeach'),),
							//array('label'=>'<span class="glyphicon glyphicon-star"></span> 提升搜尋排名', 'url'=>array('/site/pagerank')),
							array('label'=>'<i class="fa fa-flag-o"></i> 提升指標', 'url'=>array('/site/seo')),

							array('label'=>'<i class="fa fa-university"></i> '. Yii::app()->params['schoolName'], 'url'=>Yii::app()->params['schoolURL'],'linkOptions' => array('target'=>'_blank'), ),
						),
					)); ?>

					<?php $this->widget('zii.widgets.CMenu',array(
						'htmlOptions'=>array('class'=>'nav navbar-nav navbar-right'),
						'encodeLabel'=>false,
						'items'=>array(

							array('label'=>'<i class="fa fa-users"></i> 組織', 'url'=>array('/group/admin'), 'visible'=>!Yii::app()->user->isGuest,'active'=>(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id)=='group/admin',),
							array('label'=>'<i class="fa fa-tasks"></i> 網址', 'url'=>array('/siteurl/admin'), 'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'<i class="fa fa-floppy-o"></i> 手動執行', 'url'=>array('/run/'), 'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'<i class="fa fa-cog"></i>管理登入', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),							
							array('label'=>'登出 ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
						),
					)); ?>

					 <ul class="nav navbar-nav navbar-right">
					 </ul>
				</div><!--/.nav-collapse -->
			</div>
		</div><!--END nav bar-->


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
				建議使用Firefox/IE11/Chrome/Safari瀏覽網站<br/>

				Copyright &copy; <?php echo date('Y'); ?> by <a href="http://www.kuas.edu.tw">國立高雄應用科技大學</a>計算機與網路中心<br/>
				程式設計 <a href="mailto:wishnoblog@gmail.com">歐陽毅 </a> <a href="https://github.com/wishnoblog/SitePageRank">GitHub</a>
			</div>
		</div><!-- footer -->
	</body>
</html>