<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

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
	<div role="main">
		<section id="directives-calendar" ng-controller="CalendarCtrl">
			<div class="well">
				<div class="row-fluid">
					<div class="span12">
						<tabset>
							<div class="alert-success calAlert" ng-show="alertMessage != undefined && alertMessage != ''">
								<h4>{{alertMessage}}</h4>
							</div>

							<div class="row">
								<div class="col-xs-12 col-md-8">
									<div class="btn-toolbar">
										<div class="btn-group">
											<button class="btn btn-success" ng-click="changeView('month', 'myCalendar1')">Tháng</button>
											<button class="btn btn-success" ng-click="changeView('agendaWeek', 'myCalendar1')">Tuần</button>
											<button class="btn btn-success" ng-click="changeView('agendaDay', 'myCalendar1')">Ngày</button>
										</div>
									</div>
								</div>
								<div class="col-xs-6 col-md-4">
									<div ng-controller="MainCtrl" class="container">
										<button ng-click="toggleModal()" class="btn btn-primary">Add Event</button>
										<modal title="Login form" visible="showModal" style="display: none;">
										<form role="form">
											<div class="form-group">
												<label for="email">Email address</label> <input type="email" class="form-control" id="email" placeholder="Enter email" />
											</div>
											<div class="form-group">
												<label for="password">Password</label> <input type="password" class="form-control" id="password" placeholder="Password" />
											</div>
											<button type="submit" class="btn btn-default">Submit</button>
											<button type="reset" class="btn btn-default">Reset</button>
										</form>
										</modal>
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