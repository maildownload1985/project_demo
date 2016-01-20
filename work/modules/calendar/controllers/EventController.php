<?php
/**
 * @author minh-tha
 * @create date 2016-01-06
 */
namespace work\modules\calendar\controllers;

use common\models\Employee;

use common\models\work\Department;

use Yii;
use common\models\work\Event;
use common\models\work\Invitation;
use work\modules\calendar\models\eventSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\controllers\CeController;
use common\models\work\Remind;
use common\models\work\Calendar;
/**
 * EventController implements the CRUD actions for event model.
 */
class EventController extends CeController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model_event = new Event();
        $model_inviation = new Invitation();
        $model_remind = new Remind();
        $model_department = new Department();
        $model_calendar = new Calendar();
        
        if ($model_event->load(Yii::$app->request->post()) 
//         		&& $model_inviation->load(Yii::$app->request->post())
        		&& $model_remind->load(Yii::$app->request->post())
//         		&& $model_department->load(Yii::$app->request->post())
//         		&& $model_calendar->load(Yii::$app->request->post())
        		){
        	
        	$model_event->save();
        	$model_remind->save();
        	exit;
//             $model_event->insertEvent(Yii::$app->request->post());
        }
        
        return $this->render('index', [
	        		'model_event' => $model_event,
	        		'model_inviation' => $model_inviation,
	        		'model_remind' => $model_remind,
	        		'model_department' => $model_department,
        			'model_calendar' => $model_calendar
        		]);
    }

    /**
     * Displays a single event model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new eventSearch();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @created date    2015/01/13
     * 
     * get calendar
     */
    public function actionCalendar() {
        $this->layout=false;
        header('Content-type: application/json');
        /*$calendars = array(
            array(
                'title' => 'Long Event',
                'start' => '2016-01-04'
            ),
            array(
                'title' => 'test test test',
                'start' => '2016-02-04'
            ),
        		array(
        				'title' => 'test test test',
        				'start' => '2016-04-04',
        				'end' => '2016-04-05'
        		)
        );
        echo json_encode($calendars);*/
        
        $modelEvent = new Event();
        $tmpEvents = $modelEvent->getEventCalendar();
        
        $events = array();
        if (!empty($tmpEvents)) {
            foreach ($tmpEvents as $key => $value) {
                $events[] = array(
                    'id' => $value['id'],
                    'title' => $value['description'],
                    'start' => $value['start_datetime'],
                    'end' => $value['end_datetime']
                );
            }
        }
        
        echo json_encode($events);
        
    }
    
    /**
     * Updates an existing event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
	public function actionEmployee(){
        $this->layout=false;
        header('Content-type: application/json');
        
        /*{ name: 'Adam',      email: 'adam@email.com',      age: 12, country: 'United States' },
        { name: 'Amalie',    email: 'amalie@email.com',    age: 12, country: 'Argentina' },
        { name: 'Estefan a', email: 'estefania@email.com', age: 21, country: 'Argentina' },
        { name: 'Adrian',    email: 'adrian@email.com',    age: 21, country: 'Ecuador' },
        { name: 'Wladimir',  email: 'wladimir@email.com',  age: 30, country: 'Ecuador' },
        { name: 'Samantha',  email: 'samantha@email.com',  age: 30, country: 'United States' },
        { name: 'Nicole',    email: 'nicole@email.com',    age: 43, country: 'Colombia' },
        { name: 'Natasha',   email: 'natasha@email.com',   age: 54, country: 'Ecuador' },
        { name: 'Michael',   email: 'michael@email.com',   age: 15, country: 'Colombia' },
        { name: 'Nicol s',   email: 'nicole@email.com',    age: 43, country: 'Colombia' }*/
//         $employees = array(
//             array(
//                 'name' => 'Adam',
//                 'email' => 'adam@email.com',
//                 'age' => '12',
//                 'country' => 'United States'
//             ),
//             array(
//                 'name' => 'Amalie',
//                 'email' => 'amalie@email.com',
//                 'age' => '12',
//                 'country' => 'Argentina'
//             ),
//             array(
//                 'name' => 'Estefan',
//                 'email' => 'estefania@email.com',
//                 'age' => '21',
//                 'country' => ''
//             ),
//             array(
//                 'name' => 'Estefanee',
//                 'email' => 'estefaeenia@email.com',
//                 'age' => '221',
//                 'country' => ''
//             )
//         );
        
        $modelEmployee = new Employee();
        $tmpDataEmployees = $modelEmployee->getDataEmployees();
        $employees = array();
        if (!empty($tmpDataEmployees)) {
        	foreach ($tmpDataEmployees as $key => $value) {
        		$employees[] = array(
        				'id' => $value['id'],
        				'name' => $value['username'],
        				'email' => $value['email']
        		);
        	}
        }
        
        echo json_encode($employees);
    }
}
