<?php
/* @var $this SliderController */
/* @var $model Slider */

$this->breadcrumbs=array(
	'Sliders'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

require Yii::getPathOfAlias('webroot').'/protected/modules/slider/views/admin/_menu.php';
?>

<h1><? echo Yii::t('SliderModule.msg','Update Slider'); ?> <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>