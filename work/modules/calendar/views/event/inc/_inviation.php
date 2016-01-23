<?php
use common\models\work\Event;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
?>
<div class="tab-pane active" id="tab1">
	<div class="accsection">
		<div class="topwrap">
			<div class="row">
				<div class="container">
					<h4><?= Yii::t('app', 'Department');?></h4>
					<div class='col-md-6'>
					<div class="checkbox">
							<label> <input type="checkbox" id="checkAll">All</label>
						</div>
						<?= $form->field($model_department, 'id')->checkboxList(Event::getDepartmentNameCheckBox())->label(false); ?>
						
					</div>
				</div>
				<div class="container">
					<h4><?= Yii::t('app', 'Department');?></h4>
					<div class='col-md-6'>
						<div ng-controller="list_employee">
							  <ui-select multiple ng-model="multipleDemo.selectedPeople" theme="select2" ng-disabled="disabled" style="width: 100%;">
							    <ui-select-match placeholder="Select person...">{{$item.name}} &lt;{{$item.email}}&gt;</ui-select-match>
							    <ui-select-choices repeat="person in people | propsFilter: {name: $select.search, age: $select.search}">
							      <div ng-bind-html="person.name | highlight: $select.search"></div>
							      <small>
							        email: {{person.email}}
							        age: <span ng-bind-html="''+person.age | highlight: $select.search"></span>
							      </small>
							    </ui-select-choices>
							  </ui-select>
							  <br/><br/>
							  <ul>
							     <li ng-repeat=" people in multipleDemo.selectedPeople" style="visibility: hidden;">
							         <input type="hidden" name="employee[]" value="{{people.id}}"></input>
							     </li>
							  </ul>
						  <?= $this->render('_employee')?>
						  <br/>
						</div>
					</div>
				</div>
				
				<div class="container">
					<div class='col-md-6'>
						<div ng-controller="list_employee">
							<?= $form->field($model_sms, 'is_sms')->checkbox()?>
						</div>
					</div>
				</div>
				<div class="container">
					<div class='col-md-6'>
							<?= Html::Button(Yii::t('app', 'Next'), ['class'=> 'btn btn-primary btnNext']) ;?>
							<?= Html::submitButton(Yii::t('app', 'Submit'), ['class'=> 'btn btn-large btn-primary']) ;?>
							<?= Html::submitButton(Yii::t('app', 'Close'), ['class'=> 'btn btn-danger btn-default', 'data-dismiss' => 'modal']) ;?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>