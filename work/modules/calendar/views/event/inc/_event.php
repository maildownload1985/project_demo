<?php
use common\models\work\Remind;
use yii\helpers\Html;
use common\models\work\Calendar;
use common\models\work\Event;
?>
<div class="tab-pane" id="tab2">
	<div class="accsection">
		<div class="topwrap">
			<div class="row">
				<div class="container">
					<div class='col-md-3'>
						<?=$form->field ( $event, 'start_datetime', [ 'template' => '
							{label}
							<div class="form-group">
								<div class="input-group date" id="datetimepicker_start">
									{input}
									<span class="input-group-addon"> 
										<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								{error}{hint}
							</div>' ] )
						?>
										
							</div>
					<div class='col-md-3'>
						<?=$form->field ( $event, 'end_datetime', [ 'template' => '
							{label}
							<div class="form-group">
								<div class="input-group date" id="datetimepicker_end">
								{input}
								<span class="input-group-addon"> 
									<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
							{error}{hint}
							</div>' ] )?>
					</div>
				</div>

				<div class="container">
					<div class='col-md-3'><?= $form->field($model_remind, 'is_remind')->checkbox(['ng-model' => 'checked', 'ng-click' => 'checked=true'])?></div>
					<div class='col-md-3'><?= $form->field($model_remind, 'is_remind')->dropDownList(Remind::getTimeRemind(), ['ng-disabled' => '!checked']); ?></div>
				</div>

				<div class="container">
					<div class='col-md-6'><?= $form->field($event, 'name')->textInput(['maxlength' => true])?></div>
				</div>

				<div class="container">
					<div class='col-md-6'><?= $form->field($event, 'address')->textInput(['maxlength' => true])?></div>
				</div>

				<div class="container">
					<div class='col-md-6'><?= $form->field($event, 'description')->textarea(['rows' => 6])?></div>
				</div>

				<div class="container">
					<div class='col-md-6'>
						<h4><?= Yii::t('app', 'Files');?></h4>
						<div class="form-group">
						<?= $form->field($model_file, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => "file", 'data-upload-url' => '#']) ?>
						</div>
					</div>
				</div>

				<div class="container">
					<div class='col-md-6'>
						<h4><?= Yii::t('app', 'Calendar');?></h4>
						<div class="form-group">
							<?= $form->field($model_calendar, 'id')->dropDownList(Event::getCalendarOption(), ['prompt'=>  Yii::t('app', 'Please choose your type')])->label(false); ?>
						</div>
					</div>
				</div>

				<div class="container">
					<div class='col-md-6'><?= $form->field($event, 'is_public')->checkbox()?></div>
				</div>

				<div class="container">
					<div class='col-md-6 form-inline align_right'>
						<p>
                            <?= Html::submitButton(Yii::t('app', 'Submit'), ['class'=> 'btn btn-large btn-primary']) ;?>
							<?= Html::Button(Yii::t('app', 'Previous'), ['class'=> 'btn btn-primary btnPrevious']) ;?>
							<?= Html::submitButton(Yii::t('app', 'Close'), ['class'=> 'btn btn-danger btn-default', 'data-dismiss' => 'modal']) ;?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>