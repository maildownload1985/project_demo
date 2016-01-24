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
							    <ui-select-match placeholder="Select person...">
							    	<div class="test">
							    		<img alt="{{$item.urlImage}}" src="{{$item.urlImage}}" width="20px">
							    		<div style="float: right; padding: 0px 5px;">
							    		{{$item.fullname}}
							    		<br/><b>{{$item.department}}</b> 
							    		</div>
							    	</div>
							    	
							    </ui-select-match>
							    <ui-select-choices repeat="person in people | propsFilter: {fullname: $select.search, department: $select.search}">
							      <div ng-bind-html="person.fullname | highlight: $select.search"></div>
							        Department: {{person.department}}
							    </ui-select-choices>
							  </ui-select>
							  <br/>
							  <ul style="display: none">
							     <span ng-repeat="people in multipleDemo.selectedPeople" style="visibility: hidden;">
							    	 <?= $form->field($model_employee, 'id[]')->hiddenInput(['value'=>'{{people.id}}'])->label(false);?>
							     </span>
							  </ul>
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
					<div class='col-md-6 form-inline align_right'>
							<?= Html::Button(Yii::t('app', 'Next'), ['class'=> 'btn btn-primary btnNext']) ;?>
							<?= Html::submitButton(Yii::t('app', 'Close'), ['class'=> 'btn btn-danger btn-default', 'data-dismiss' => 'modal']) ;?>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>