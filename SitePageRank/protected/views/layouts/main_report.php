<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
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

			<div  class="container">
				<?php echo $content; ?>
			</div><!-- end container -->
	</body>
</html>