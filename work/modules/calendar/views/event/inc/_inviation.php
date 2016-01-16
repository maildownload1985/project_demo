<?php
use common\models\work\Event;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
?>
<div class="tab-pane" id="tab2">
	<div class="accsection">
		<div class="topwrap">
			<div class="row">
				<div class="container">
					<h4><?= Yii::t('app', 'Department');?></h4>
					<div class='col-md-6'>
						<?= $form->field($model_department, 'id', ['template' => "{label}\n{input}\n{hint}\n{error}"])->checkboxList(Event::getDepartmentNameCheckBox(), ['id' => 'inviation_deparment_id'])->label(false); ?>
						<div class="checkbox">
							<label> <input type="checkbox" id="checkAll"></label>
						</div>
					</div>
				</div>
				<div class="container">
					<div class='col-md-6'>
						<p>
							<?= Html::Button(Yii::t('app', 'Previous'), ['class'=> 'btn btn-primary btnPrevious']) ;?>
							<?= Html::Button(Yii::t('app', 'Submit'), ['class'=> 'btn btn-large btn-primary']) ;?>
							<?= Html::Button(Yii::t('app', 'Close'), ['class'=> 'btn btn-large']) ;?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>