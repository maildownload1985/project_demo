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
use common\models\work\Sms;
use common\models\work\Activity;
use common\models\work\Notification;
use common\models\work\File;
use common\models\work\EmployeeActivity;
use yii\web\UploadedFile;
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
        $model_employee = new Employee();
        $model_sms = new Sms();
        $model_file = new File();
        
        if ($model_event->load(Yii::$app->request->post()) 
//         		&& $model_inviation->load(Yii::$app->request->post())
//         		&& $model_remind->load(Yii::$app->request->post())
//         		&& $model_department->load(Yii::$app->request->post())
//         		&& $model_calendar->load(Yii::$app->request->post())
        		){
        			print_r(Yii::$app->request->post());
            //___________________________ Start insert table event ___________________________
            
        	$model_calendar->load(Yii::$app->request->post());
        	$model_event->calendar_id = $model_calendar->id;
        	$model_event->employee_id = Yii::$app->user->identity->id;
        	$model_event->description_parse = $model_event->description;
        	$model_event->start_datetime = strtotime($model_event->start_datetime);
        	$model_event->end_datetime   = strtotime($model_event->end_datetime);
        	$model_event->save();
        	//___________________________ END insert table event ___________________________
        	
        	
        	//___________________________ Start insert table Invitation ___________________________
        	$model_department->load(Yii::$app->request->post());
        	
        	
        	$data_department_ids = [];
        	foreach ($model_department->id as $type) {
        		$data_department_ids[] = [
        				'event_id' => $model_event->id, 
        				'owner_id' => $type,
        				'owner_table' => 'department'
        		];
        	}
        	
        	//getlist department
        	$connection = \Yii::$app->db;
        	$connection->createCommand()->batchInsert($model_inviation->tableName(), array_keys($data_department_ids[0]), $data_department_ids)->execute();
        	
        	//getlist emplyoee
        	$employees = [1, 2, 3];
        	foreach ($employees as $type) {
        		$data_employee_ids[] = [
        				'event_id' => $model_event->id,
        				'owner_id' => $type,
        				'owner_table' => 'employee'
        		];
        	}
        	$connection->createCommand()->batchInsert($model_inviation->tableName(), array_keys($data_employee_ids[0]), $data_employee_ids)->execute();
        	//___________________________ END insert table Invitation ___________________________
        	
        	
        	
        	
        	//___________________________ Start insert table Redmind ___________________________
        	// when click checkbox is remind will insert in table remind
        	$model_remind->load(Yii::$app->request->post());
//         	if ($model_remind->is_remind) {
	        	$employee = [1, 2, 3];
	   			$data_employee =  $model_employee->find()->Where(
	        		['or', 
	        			['department_id' => $model_department->id],//list select department
	        			['id' => $employee]////list select employee
		        	]
	   			)->all();
	        		
	        	$data_reminds = [];
	        	foreach ($data_employee as $type) {
	        		$data_reminds[] = [
	        				'employee_id' => $type->id,
	        				'owner_id' => $model_event->id,
	        				'owner_table' => 'event',
	        				'content' => $model_event->name,
	        				'remind_datetime' => $model_event->start_datetime,
	        				'minute_before' => $model_remind->minute_before,
	        		];
	        	}
	        	
	        	$connection->createCommand()->batchInsert($model_remind->tableName(), array_keys($data_reminds[0]), $data_reminds)->execute();
//         	}
        	//___________________________ END insert table Redmind ___________________________
        	
        	//___________________________ Start insert table Employee_activity: ___________________________
	        $model_EmployeeActivity = new EmployeeActivity();
	        if($data_EmployeeActivitys = $model_EmployeeActivity->find()->andWhere(['employee_id' => Yii::$app->user->identity->id])->one()){
	        	$data_EmployeeActivitys->activity_calendar  += 1;
	        	$data_EmployeeActivitys->activity_total  += 1;
	        	$data_EmployeeActivitys->save();
	        }else {
	        	$model_EmployeeActivity->employee_id  = Yii::$app->user->identity->id;
	        	$model_EmployeeActivity->activity_calendar  = 1;
	        	$data_EmployeeActivitys->activity_total  = 1;
	        	$model_EmployeeActivity->save();
	        }
        	//___________________________ END insert table Employee_activity ___________________________

        	
        	//___________________________ Start insert table Activity: ___________________________
        	$model_Activity = new Activity();
        	$model_Activity->owner_id = $model_event->id;
        	$model_Activity->owner_table = 'event';
        	$model_Activity->parent_employee_id = 0;
        	$model_Activity->employee_id = Yii::$app->user->identity->id;
        	$model_Activity->type = 'create_event';
        	$model_Activity->content = $model_employee->getFullNameLogin(). ' '. Yii::t('work', 'created') . $model_event->name;
        	$model_Activity->save();
        	
        	//___________________________ END insert table Activity ___________________________

        	
        	//___________________________ Start insert table File: ___________________________
        	$model_file->load(Yii::$app->request->post());
        	$fileList = ["a.pdf", "c.pdf", "b.pdf"];
        	$model_file->imageFiles = UploadedFile::getInstances($model_file, 'imageFiles');
        	
        	print_r($model_file->imageFiles) ;
        	exit;
        	exit;
//         	$model_file->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
//         	if ($model->upload()) {
//         		// file is uploaded successfully
//         		return;
//         	}
        	
        	$data_files = [];
        	foreach ($fileList as $type) {
        		$data_files[] = [
        				'owner_id' => $model_event->id,
        				'employee_id' => Yii::$app->user->identity->id,
        				'owner_object' => 'event',
        				'name' => $type,//name
        				'encoded_name' => 'file encoded_name',
        				'path' => 'URL',
        				'is_image' => 0,
        				'file_type' => 'type file',
        				'file_size' => 99,
        		];
        	}
        	$connection->createCommand()->batchInsert($model_file->tableName(), array_keys($data_files[0]), $data_files)->execute();
        	//___________________________ END insert table File ___________________________
        	
        	
        	//___________________________ Start insert table Notification: ___________________________
        	
        	$employee = [1, 2, 3];
        	$data_employee =  $model_employee->find()->Where(
        			['or',
        					['department_id' => $model_department->id],//list select department
        					['id' => $employee]////list select employee
        			]
        			)->all();
        			 
        			$data_Notification = [];
        			foreach ($data_employee as $type) {
        				$data_Notification[] = [
        						'owner_id' => $model_event->id,
        						'owner_table' => 'event',
								'employee_id' => $type->id,
        						'owner_employee_id' => 0,
        						'type' => 'create_event',
        						'content' => $model_employee->getFullNameLogin(). ' '. Yii::t('work', 'created') . $model_event->name
        				];
        			}
        			$model_Notification = new Notification();
        			$connection = \Yii::$app->db;
        			$connection->createCommand()->batchInsert($model_Notification->tableName(), array_keys($data_Notification[0]), $data_Notification)->execute();
        			
        	//___________________________ END insert table Notification: ___________________________
        	
        	
        			
        			
        	//___________________________ Start insert table send mail ___________________________
        			
        	//___________________________ END insert table send mail: ___________________________
        	
        			
        			
        			
        			
        	//___________________________ Start insert table SMS ___________________________
        	//         	if ($model_remind->is_remind) {//@todo after change SMS
        	$employee = [1, 2, 3];
        	
        	$data_employee =  $model_employee->find()->Where(
        			['or',
        					['department_id' => $model_department->id],//list select department
        					['id' => $employee]////list select employee
        			]
        			)->all();
        			$data_SMS = [];
        			foreach ($data_employee as $type) {
        				$data_SMS[] = [
        						'employee_id' => $model_event->id,
        						'owner_id' => $type->id,
        						'owner_table' => 'event',
        						'content' => $model_employee->getFullNameLogin(). ' '. Yii::t('work', 'created') . $model_event->name,
        						'is_success' => 1,
        						'fee' => 0,
        				];
        			}
        			 
        			$connection->createCommand()->batchInsert($model_sms->tableName(), array_keys($data_SMS[0]), $data_SMS)->execute();
        			 
        			//         	}
        			//___________________________ END insert table SMS ___________________________
        }
        return $this->render('index', [
	        		'model_event' => $model_event,
	        		'model_inviation' => $model_inviation,
	        		'model_remind' => $model_remind,
	        		'model_department' => $model_department,
        			'model_calendar' => $model_calendar,
        			'model_sms' => $model_sms,
        			'model_file' => $model_file
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
