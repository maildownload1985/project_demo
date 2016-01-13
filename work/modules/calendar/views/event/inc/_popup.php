<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\calendar\event */
/* @var $form yii\widgets\ActiveForm */
?>
<modal title="<?= Yii::t('app', 'TITLE FORM');?>" visible="showModal" style="display: none;">
	<?php $form = ActiveForm::begin(); ?>
	<ul class="nav nav-tabs">
		<li class="active"><a href="#{{contentBaseId}}-1" data-toggle="tab"><?= Yii::t('app', 'Event');?></a></li>
		<li><a href="#{{contentBaseId}}-2" data-toggle="tab"><?= Yii::t('app', 'Inviation');?></a></li>
	</ul>

	<div class="tab-content">
		<?= $this->render('_event', ['model' => $model]) ?>
	
		<?= $this->render('_inviation', ['model' => $model]) ?>
	</div>
	<?php ActiveForm::end(); ?>
</modal>
