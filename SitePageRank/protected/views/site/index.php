<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl .'/themes/bootstrap/css/one-page-wonder.css' );  
Yii::app()->getClientScript()->registerCss('index','
.btn-outline-inverse {
    background-color: transparent;
    border-bottom-color: #317eac;
    border-left-color-ltr-source: physical;
    border-left-color-rtl-source: physical;
    border-left-color: 	#317eac;
    border-right-color-ltr-source: physical;
    border-right-color-rtl-source: physical;
    border-right-color: #317eac;
    border-top-color: 	#317eac;
    
}
.counters span {
    font-size: 35px;
}
	');
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl .'/themes/bootstrap/js/waypoints.min.js');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl .'/themes/bootstrap/js/jquery.counterup.min.js');


?>

<header class="header-image">
    <div class="headline">
        <div class="container">
            <h1><?php echo CHtml::encode(Yii::app()->name); ?><br><small>各單位系所網站資訊統計系統</small></h1>

			<br>
			<!-- Contextual button for informational alert messages -->

            <div class="row">
                <div class="counters col-md-4 col-sm-4">
                    <span class="counter">
                    <?php echo (Data::model()->count())*8;?>
                    </span>
                    <h4>登錄資料筆數</h4>
                </div>
                <div class="counters col-md-4 col-sm-4">
                    <span class="counter"> <?php echo (Group::model()->count());?></span>
                    <h4>網站數</h4>
                </div>
                <div class="counters col-md-4 col-sm-4">
                    <span class="counter"> <?php echo SiteUrl::model()->count();?></span>
                    <h4>單位及系所數</h4>
                </div>
            </div>

            <p class="lead">
                <a class="btn btn-outline-inverse btn-lg"  href = <?php echo '"' . Yii::app()->request->url . '/行政單位排名'.'"';?> ><i class="fa fa-university fa-lg"></i>  行政單位排名</a> <a class="btn btn-outline-inverse btn-lg"  href = <?php echo '"' . Yii::app()->request->url . '/學術單位排名'.'"';?> ><i class="fa fa-graduation-cap fa-lg"></i>  學術單位排名</a>
            </p>
        </div>
    </div>
</header>
    <script>
        jQuery(document).ready(function($) {
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });
        });
    </script>


