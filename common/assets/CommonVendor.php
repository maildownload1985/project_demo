<?php
namespace common\assets;

use Yii;
use yii\web\AssetBundle;

class CommonVendor extends AssetBundle
{
    public $basePath;
    public $baseUrl = '/vendor/bower/';
    
    public $css = [
    		'works/calendar/css/fullcalendar.css',
    		'works/calendar/css/fullcalendar.print.css',
    		'works/calendar/css/calendar.css'
    ];
    
    public $js = [
    		'/vendor/bower/works/calendar/js/jquery.js',
    		'/vendor/bower/works/calendar/js/angular.js',
    		'/vendor/bower/works/calendar/js/ui-bootstrap-tpls-0.9.0.js',
    		'/vendor/bower/works/calendar/js/moment.js',
    		'/vendor/bower/works/calendar/js/fullcalendar.js',
    		'/vendor/bower/works/calendar/js/gcal.js',
    		'/vendor/bower/works/calendar/js/angular-locale_vi-vn.js',
    		'/vendor/bower/works/calendar/js/calendar.js',
    		'/vendor/bower/works/calendar/js/calendarDemo.js',
    ];
    
    public $depends = [
    		'yii\web\YiiAsset',
    ];
    
    public function __construct($config = array()) {
        parent::__construct($config);
        $this->basePath = str_replace(['work', 'hrm', 'kpi'], ['common'], Yii::getAlias("@webroot"));
    }
}
