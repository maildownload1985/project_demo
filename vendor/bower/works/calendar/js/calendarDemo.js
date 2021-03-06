/**
 * calendarDemoApp - 0.9.0
 */
var calendarDemoApp = angular.module('calendarDemoApp', ['ui.calendar', 'ui.bootstrap', 'ngSanitize', 'ui.select']);

calendarDemoApp.controller('CalendarCtrl',
   function($scope, $compile, $timeout, uiCalendarConfig, $http) {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $scope.changeTo = 'Hungarian';
    /* event source that pulls from google.com */
    $scope.eventSource = {
            url: "http://www.google.com/calendar/feeds/usa__en%40holiday.calendar.google.com/public/basic",
            className: 'gcal-event',           // an option!
            currentTimezone: 'America/Chicago' // an option!
    };
    /* event source that contains custom events on the scope */
    /*$scope.events = [
      {title: 'All Day Event',start: new Date(y, m, 1)},
      {title: 'Long Event',start: new Date(y, m, d - 5),end: new Date(y, m, d - 2)},
      {id: 999,title: 'Repeating Event',start: new Date(y, m, d - 3, 16, 0),allDay: false},
      {id: 999,title: 'Repeating Event',start: new Date(y, m, d + 4, 16, 0),allDay: false},
      {title: 'Birthday Party',start: new Date(y, m, d + 1, 19, 0),end: new Date(y, m, d + 1, 22, 30),allDay: false},
      {title: 'Click for Google',start: new Date(y, m, 28),end: new Date(y, m, 29),url: 'http://google.com/'}
    ];*/
    $scope.events = [];
    $http.get(window.location.host + '/work/web/index.php?r=calendar/event/calendar').success(function(data){  //fetch new events from server, and push in array
    	$scope.schedule = data;
    		for(var i=0;i<data.length;i++)
    			{
    	            $scope.events.push({
	            		//idx: data[i].idx,
    	            	title: data[i].title,
    	            	//description : data[i].description,
    	            	allDay: false,
    	            	//start: new Date(data[i].start),
    	            	start: data[i].start,
	            		//end:  new Date(data[i].end),
    	            });
    	     //calendar.fullCalendar('render'); //Tried even this, didn't work
      }
    });
    /* event source that calls a function on every view switch */
    $scope.eventsF = function (start, end, timezone, callback) {
      var s = new Date(start).getTime() / 1000;
      var e = new Date(end).getTime() / 1000;
      var m = new Date(start).getMonth();
      var events = [{title: 'Feed Me ' + m,start: s + (50000),end: s + (100000),allDay: false, className: ['customFeed']}];
      //callback(events);
      callback($scope.events);
      
      $('td.fc-day').bind('dblclick', function() {
    	  $('.modal').modal('show')  
      });
      $('td.fc-day-number').bind('dblclick', function() {
    	  $('.modal').modal('show')  
      });
      //$("#event-start_datetime").datepicker().attr('readonly','readonly');
      //$("#event-end_datetime").datepicker().attr('readonly','readonly');
      $('#event-start_datetime').attr('readonly', true);
      $('#datetimepicker_start').datetimepicker({
    	    ignoreReadonly: true
    	  });
      $('#event-end_datetime').attr('readonly', true);
      $('#datetimepicker_end').datetimepicker({
    	    ignoreReadonly: true
    	  });
      
      $("#checkAll").change(function () {
          $("#inviation_deparment_id input:checkbox").prop('checked', $(this).prop("checked"));
      });
   	
      $("input[name='Department[id][]']").click(function(){
      	//console.log($("input[name='Department[id][]']").length);
      	//console.log($("input[name='Department[id][]']:checked").length);
          if($("input[name='Department[id][]']").length == $("input[name='Department[id][]']:checked").length) {
          	$("#checkAll").prop("checked", true);
          } else {
          	$("#checkAll").removeAttr("checked");;
          }
   
      });
    };
    $scope.calEventsExt = {
       color: '#f00',
       textColor: 'yellow',
       events: [
          {type:'party',title: 'Lunch',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},
          {type:'party',title: 'Lunch 2',start: new Date(y, m, d, 12, 0),end: new Date(y, m, d, 14, 0),allDay: false},
          {type:'party',title: 'Click for Google',start: new Date(y, m, 28),end: new Date(y, m, 29),url: 'http://google.com/'}
        ]
    };
    /* alert on eventClick */
    $scope.alertOnEventClick = function( date, jsEvent, view){
        $scope.alertMessage = (date.title + ' was clicked ');
    };
    /* alert on Drop */
     $scope.alertOnDrop = function(event, delta, revertFunc, jsEvent, ui, view){
       $scope.alertMessage = ('Event Dropped to make dayDelta ' + delta);
    };
    /* alert on Resize */
    $scope.alertOnResize = function(event, delta, revertFunc, jsEvent, ui, view ){
       $scope.alertMessage = ('Event Resized to make dayDelta ' + delta);
    };
    /* add and removes an event source of choice */
    $scope.addRemoveEventSource = function(sources,source) {
      var canAdd = 0;
      angular.forEach(sources,function(value, key){
        if(sources[key] === source){
          sources.splice(key,1);
          canAdd = 1;
        }
      });
      if(canAdd === 0){
        sources.push(source);
      }
    };
    /* add custom event*/
    $scope.addEvent = function() {
      $scope.events.push({
        title: 'Open Sesame',
        start: new Date(y, m, 28),
        end: new Date(y, m, 29),
        className: ['openSesame']
      });
    };
    /* remove event */
    $scope.remove = function(index) {
      $scope.events.splice(index,1);
    };
    /* Change View */
    $scope.changeView = function(view,calendar) {
      uiCalendarConfig.calendars[calendar].fullCalendar('changeView',view);
    };
    /* Change View */
    $scope.renderCalender = function(calendar) {
      $timeout(function() {
        if(uiCalendarConfig.calendars[calendar]){
          uiCalendarConfig.calendars[calendar].fullCalendar('render');
        }
      });
    };
     /* Render Tooltip */
    $scope.eventRender = function( event, element, view ) {
        element.attr({'tooltip': event.title,
                      'tooltip-append-to-body': true});
        $compile(element)($scope);
        
        /*$('td.fc-day').bind('dblclick', function() {
        	//alert('double click!');
        	//$('.modal').modal('show')  
        });*/
 	
    	$('td.fc-day').bind('dblclick', function() {
    		$('.modal').modal('show')  
    	});
    	$('td.fc-day-number').bind('dblclick', function() {
    		$('.modal').modal('show')  
    	});
    };
    /* Bind date to input  */
    $scope.dayClick = function( date, jsEvent, view, resourceObj ) { 
    	var current_date = new Date;
    	var current_hours = current_date.getHours();
    	if (current_hours < 10) {
    		current_hours = "0" + current_hours;
        }
    	var ampm = (current_hours >= 12) ? "PM" : "AM";
    	var current_minute = current_date.getMinutes();
    	if (current_minute < 10) {
    		current_minute = "0" + current_minute;
        }
    	var current_time = current_hours + ":" + current_minute + ' ' + ampm;
    	var get_date = date.format();
    	var date = new Date(get_date);
    	var format_date = ("0" + (date.getMonth() + 1)).slice(-2) + '/' + ("0" + date.getDate()).slice(-2) + '/' +  date.getFullYear();
    	var hours = date.getHours();
    	//$('#event-start_datetime').val(date.format());
    	$('#event-start_datetime').val(format_date + ' ' + current_time);
    };

    /* config object */
    $scope.uiConfig = {
      calendar:{
        height: 450,
        editable: true,
        header:{
          left: 'title',
          center: '',
          right: 'today prev,next'
        },
        eventClick: $scope.alertOnEventClick,
        eventDrop: $scope.alertOnDrop,
        eventResize: $scope.alertOnResize,
        eventRender: $scope.eventRender,
        dayClick: $scope.dayClick
      }
    };

    $scope.changeLang = function() {
      if($scope.changeTo === 'Hungarian'){
        $scope.uiConfig.calendar.dayNames = ["Vasárnap", "Hétfő", "Kedd", "Szerda", "Csütörtök", "Péntek", "Szombat"];
        $scope.uiConfig.calendar.dayNamesShort = ["Vas", "Hét", "Kedd", "Sze", "Csüt", "Pén", "Szo"];
        $scope.changeTo= 'English';
      } else {
        $scope.uiConfig.calendar.dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        $scope.uiConfig.calendar.dayNamesShort = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        $scope.changeTo = 'Hungarian';
      }
    };
    /* event sources array*/
    $scope.eventSources = [$scope.events, $scope.eventSource, $scope.eventsF, $scope.eventsE];
    $scope.eventSources2 = [$scope.calEventsExt, $scope.eventsF, $scope.events];
});
/* EOF */

//var modal = angular.module('btfModal', ['btfModal.modal']);

//let's make a modal called `myModal`
calendarDemoApp.factory('myModal', function (btfModal) {
	return btfModal({
	 controller: 'MyModalCtrl',
	 controllerAs: 'modal',
	 templateUrl: '/vendor/bower/works/calendar/css/modal/modal.html'
	});
}).

//typically you'll inject the modal service into its own
//controller so that the modal can close itself
controller('MyModalCtrl', function ($scope, $timeout, myModal) {

var ctrl = this,
   timeoutId;

ctrl.tickCount = 5;

ctrl.closeMe = function () {
 cancelTick();
 myModal.deactivate();
};

function tick() {
 timeoutId = $timeout(function() {
   ctrl.tickCount -= 1;
   if (ctrl.tickCount <= 0) {
     ctrl.closeMe();
   } else {
     tick();
   }
 }, 1000);
}

function cancelTick() {
 $timeout.cancel(timeoutId);
}

$scope.$on('$destroy', cancelTick);

tick();
}).

controller('MyCtrl', function (myModal) {
this.showModal = myModal.activate;
});
















calendarDemoApp.controller('MainCtrl', function ($scope) {
    $scope.showModal = false;
    $scope.toggleModal = function(){
        $scope.showModal = !$scope.showModal;
        $("#checkAll").change(function () {
        	//alert('check all');
            $("#inviation_deparment_id input:checkbox").prop('checked', $(this).prop("checked"));
        	//$("#inviation_deparment_id input:checkbox").attr("checked", "checked");
        });
        
     	// if all checkbox are selected, check the selectall checkbox
        // and viceversa
        /*$("#inviation_deparment_id input[type='checkbox']:not(#checkAll)").click(function(){
        	console.log('aaa');
        	console.log($("#inviation_deparment_id input[type='checkbox']:not(#checkAll)"));
        	console.log($("#inviation_deparment_id input[type='checkbox']:not(#checkAll):checked").length);
            if($("#inviation_deparment_id input[type='checkbox']:not(#checkAll)").length == $("#inviation_deparment_id input[type='checkbox']:not(#checkAll):checked").length) {
            	$("#checkAll").attr("checked", "checked");
            } else {
            	$("#checkAll").removeAttr("checked");;
            }
     
        });*/
        $("input[name='Department[id][]']").click(function(){
        	//console.log($("input[name='Department[id][]']").length);
        	//console.log($("input[name='Department[id][]']:checked").length);
            if($("input[name='Department[id][]']").length == $("input[name='Department[id][]']:checked").length) {
            	$("#checkAll").prop("checked", true);
            } else {
            	$("#checkAll").removeAttr("checked");;
            }
     
        });
        
    };
  });

calendarDemoApp.directive('modal', function () {
    return {
//    	templateUrl: '/vendor/bower/works/calendar/css/modal/modal.html'
        
    		template: '<div class="modal fade">' + 
            '<div class="modal-dialog">' + 
              '<div class="modal-content">' + 
                '<div class="modal-header">' + 
                  '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' + 
                  '<h4 class="modal-title">{{ title }}</h4>' + 
                '</div>' + 
                '<div class="modal-body" ng-transclude></div>' + 
              '</div>' + 
            '</div>' + 
          '</div>',
      restrict: 'E',
      transclude: true,
      replace:true,
      scope:true,
      link: function postLink(scope, element, attrs) {
        scope.title = attrs.title;

        scope.$watch(attrs.visible, function(value){
          if(value == true)
            $(element).modal('show');
          else
            $(element).modal('hide');
        });

        $(element).on('shown.bs.modal', function(){
          scope.$apply(function(){
            scope.$parent[attrs.visible] = true;
          });
        });

        $(element).on('hidden.bs.modal', function(){
          scope.$apply(function(){
            scope.$parent[attrs.visible] = false;
          });
        });
      }
    };
  });
















































/**
 * AngularJS default filter with the following expression:
 * "person in people | filter: {name: $select.search, age: $select.search}"
 * performs a AND between 'name: $select.search' and 'age: $select.search'.
 * We want to perform a OR.
 */
calendarDemoApp.filter('propsFilter', function() {
  return function(items, props) {
    var out = [];

    if (angular.isArray(items)) {
      items.forEach(function(item) {
        var itemMatches = false;

        var keys = Object.keys(props);
        for (var i = 0; i < keys.length; i++) {
          var prop = keys[i];
          var text = props[prop].toLowerCase();
          if (item[prop].toString().toLowerCase().indexOf(text) !== -1) {
            itemMatches = true;
            break;
          }
        }

        if (itemMatches) {
          out.push(item);
        }
      });
    } else {
      // Let the output be the input untouched
      out = items;
    }

    return out;
  };
});


calendarDemoApp.controller('list_employee', function($scope, $http, $timeout) {
  $scope.disabled = undefined;
  $scope.searchEnabled = undefined;

  $scope.enable = function() {
    $scope.disabled = false;
  };

  $scope.disable = function() {
    $scope.disabled = true;
  };

  $scope.enableSearch = function() {
    $scope.searchEnabled = true;
  }

  $scope.disableSearch = function() {
    $scope.searchEnabled = false;
  }

  $scope.clear = function() {
    $scope.person.selected = undefined;
    $scope.address.selected = undefined;
    $scope.country.selected = undefined;
  };
  

  $scope.counter = 0;
  $scope.someFunction = function (item, model){
    $scope.counter++;
    $scope.eventResult = {item: item, model: model};
  };

  $scope.person = {};
  
  $scope.people = [];
  
  $http.get(window.location.host + '/work/web/index.php?r=calendar/event/employee').then(function(response) {
	   $scope.people = response.data;
  });
  
  $scope.multipleDemo = {};
});
