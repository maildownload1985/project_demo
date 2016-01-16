<?php
/* @var $this yii\web\View */
/* @var $model common\models\calendar\event */

$this->title = 'Create Event';
$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Events',
		'url' => [ 
				'index' 
		] 
];

$this->params ['breadcrumbs'] [] = $this->title;
?>



<div ng-app="calendarDemoApp" class="event-create">


<div class="container">
					<h4><?= Yii::t('app', 'Department');?></h4>
					<div class='col-md-6'>
						<div ng-controller="list_employee">
							<ui-select multiple ng-model="multipleDemo.selectedPeopleWithGroupBy" theme="select2" ng-disabled="disabled" > 
								<ui-select-match placeholder="Select person..." width="500px">{{$item.name}} &lt;{{$item.email}}&gt;</ui-select-match>
								
								<ui-select-choices group-by="someGroupFn" repeat="person in people | propsFilter: {name: $select.search, age: $select.search}">
									<div ng-bind-html="person.name | highlight: $select.search"></div>
									<small> 
										email: {{person.email}} age:  <span ng-bind-html="''+person.age | highlight: $select.search"></span>
									</small> 
								</ui-select-choices> 
							</ui-select>
							<p>Selected: {{multipleDemo.selectedPeopleWithGroupBy}}</p>
						</div>
					</div>
				</div>
	<div role="main">
		<section id="directives-calendar" ng-controller="CalendarCtrl">
			<div class="well">
				<div class="row-fluid">
					<div class="span12">
						<tabset>
							<div class="alert-success calAlert" ng-show="alertMessage != undefined && alertMessage != ''" style="display: none;">
								<h4>{{alertMessage}}</h4>
							</div>

							<div class="row">
								<div class="col-xs-12 col-md-8">
									<div class="btn-toolbar">
										<div class="btn-group">
											<button class="btn btn-success" ng-click="changeView('month', 'myCalendar1')"><?= Yii::t('app', 'Month');?></button>
											<button class="btn btn-success" ng-click="changeView('agendaWeek', 'myCalendar1')"><?= Yii::t('app', 'Week');?></button>
											<button class="btn btn-success" ng-click="changeView('agendaDay', 'myCalendar1')"><?= Yii::t('app', 'Day');?></button>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-md-4">
									<div ng-controller="MainCtrl" class="container">
										<button ng-click="toggleModal()" class="btn btn-primary"><?= Yii::t('app', 'Add Event');?></button>
										<?= $this->render('inc/_popup', [
												'event' => $model_event, 
												'model_remind' => $model_remind, 
												'inviation' => $model_inviation, 
												'model_department' => $model_department,
												'model_calendar' => $model_calendar
										]) ?>
									</div>
								</div>
							</div>
							<div class="calendar" ng-model="eventSources" calendar="myCalendar1" ui-calendar="uiConfig.calendar"></div>
						</tabset>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>