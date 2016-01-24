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
        $model_remind = new Remind();
        $model_department = new Department();
        $model_employee = new Employee();
        $model_sms = new Sms();
        $model_file = new File();
        
        if ($model_event->load(Yii::$app->request->post()) 
        		&& $model_remind->load(Yii::$app->request->post())
        		&& $model_department->load(Yii::$app->request->post())
        		&& $model_file->load(Yii::$app->request->post())
        		&& $model_sms->load(Yii::$app->request->post())
        		){
        	
        	//======================= Start insert table event =======================
        	$model_event->employee_id = Yii::$app->user->identity->id;
        	$model_event->description_parse = $model_event->description;
        	$model_event->start_datetime = strtotime($model_event->start_datetime);
        	$model_event->end_datetime   = strtotime($model_event->end_datetime);
        	$model_event->save();
        	//======================= END insert table event =======================
        	
        	//get list department Post
        	$data_department_ids = [];
        	foreach ($model_department->id as $type) {
        		$data_department_ids[] = [
        		'event_id' => $model_event->id,
        		'owner_id' => $type,
        		'owner_table' => 'department'
        		];
        	}
        	
        	//getlist employee Post
        	$model_employee->load(Yii::$app->request->post());
        	$data_employee_ids = [];// info data insert table Reminds
        	if (!empty($model_employee->id)) {
        		foreach ($model_employee->id as $type) {
        			$data_employee_ids[] = [
        			'event_id' => $model_event->id,
        			'owner_id' => $type,
        			'owner_table' => 'employee'
        			];
        		}
        		$data_employees 	=  $model_employee->find()->Where(['or', ['department_id' => $model_department->id], ['id' => $model_employee->id]])->all();
        	} else {
        		$data_employees 	=  $model_employee->find()->andWhere(['department_id' => $model_department->id])->all();
        	}
        	// get info by department Post and employee Post
//         	
        	
        	$data_reminds 		= [];// info data insert table Reminds
        	$data_Notification 	= [];// info data insert table Notification
        	$data_SMS 			= [];// info data insert table SMS
        	 
        	if (!empty($data_employees)) {
	        	foreach ($data_employees as $type) {
	        		$data_reminds[] = [
		        		'employee_id' 		=> $type->id,
		        		'owner_id' 			=> $model_event->id,
		        		'owner_table' 		=> 'event',
		        		'content' 			=> $model_event->name,
		        		'remind_datetime'	=> $model_event->start_datetime,
		        		'minute_before'		=> $model_remind->minute_before,
	        		];
	        		
	        		$data_Notification[] = [
		        		'owner_id' 			=> $model_event->id,
		        		'owner_table' 		=> 'event',
		        		'employee_id' 		=> $type->id,
		        		'owner_employee_id' => 0,
		        		'type'				=> 'create_event',
		        		'content' 			=> $model_employee->getFullNameLogin(). ' '. Yii::t('work', 'created') . $model_event->name
	        		];
	        		
	        		$data_SMS[] = [
		        		'employee_id' 		=> $model_event->id,
		        		'owner_id' 			=> $type->id,
		        		'owner_table' 		=> 'event',
		        		'content' 			=> $model_employee->getFullNameLogin(). ' '. Yii::t('work', 'created') . $model_event->name,
		        		'is_success' 		=> 1,
		        		'fee' 				=> 0,
	        		];
	        	}
        	
	        	// connect insert batch
	        	$connection = \Yii::$app->db;
	        	
	        	//======================= Start insert table Invitation =======================
	        	$connection->createCommand()->batchInsert(Invitation::tableName(), array_keys($data_department_ids[0]), $data_department_ids)->execute();
	        	if (!empty($model_employee->id)) {
	        		$connection->createCommand()->batchInsert(Invitation::tableName(), array_keys($data_employee_ids[0]), $data_employee_ids)->execute();
	        	}
	        	//======================= END insert table Invitation =======================
	        	
	        	//======================= Start insert table Redmind =======================
	        	// when click checkbox is remind will insert in table remind
	        	
	        	
	        	if ($model_remind->is_remind) {
		        	$connection->createCommand()->batchInsert($model_remind->tableName(), array_keys($data_reminds[0]), $data_reminds)->execute();
	        	}
	        	//======================= END insert table Redmind =======================
	        	
	        	//======================= Start insert table Notification: =======================
	        	$connection->createCommand()->batchInsert(Notification::tableName(), array_keys($data_Notification[0]), $data_Notification)->execute();
	        	 
	        	//======================= END insert table Notification: =======================
	        	
	        	//======================= Start insert table Employee_activity: =======================
		        //check info data table EmployeeActivity is exist
	        	$model_EmployeeActivity = new EmployeeActivity();
		        if($data_EmployeeActivitys = $model_EmployeeActivity->find()->andWhere(['employee_id' => Yii::$app->user->identity->id])->one()){
		        	$data_EmployeeActivitys->activity_calendar  += 1;
		        	$data_EmployeeActivitys->activity_total  	+= 1;
		        	$data_EmployeeActivitys->save();
		        }else {
		        	$model_EmployeeActivity->employee_id  		= Yii::$app->user->identity->id;
		        	$model_EmployeeActivity->activity_calendar  = 1;
		        	$data_EmployeeActivitys->activity_total  	= 1;
		        	$model_EmployeeActivity->save();
		        }
	        	//======================= END insert table Employee_activity =======================
	
	        	
	        	//======================= Start insert table Activity: =======================
		        $model_Activity = new Activity();
	        	$model_Activity->owner_id 			= $model_event->id;
	        	$model_Activity->owner_table 		= 'event';
	        	$model_Activity->parent_employee_id = 0;
	        	$model_Activity->employee_id 		= Yii::$app->user->identity->id;
	        	$model_Activity->type 				= 'create_event';
	        	$model_Activity->content 			= $model_employee->getFullNameLogin(). ' '. Yii::t('work', 'created') . $model_event->name;
	        	$model_Activity->save();
	        	//======================= END insert table Activity =======================
	
	        	
	        	//======================= Start insert table File: =======================
	        	$model_file->imageFiles = UploadedFile::getInstances($model_file, 'imageFiles');
	        	$model_file->owner_id =  $model_event->id;
	        	$model_file->upload();
	        	//======================= END insert table File =======================
	        	
	        	//======================= Start insert table send mail =======================
				// chua code
	        	//======================= END insert table send mail: =======================
	        	
	        	//======================= Start insert table SMS =======================
	        	if ($model_sms->is_sms) {
	        		$connection->createCommand()->batchInsert($model_sms->tableName(), array_keys($data_SMS[0]), $data_SMS)->execute();
	        	}
        	} else {
        		
        	}
        	//======================= END insert table SMS =======================
        } else{
        	
        }
        
        return $this->render('index', [
	        		'model_event' => $model_event,
	        		'model_remind' => $model_remind,
	        		'model_department' => $model_department,
        			'model_sms' => $model_sms,
        			'model_file' => $model_file,
        			'model_employee' => $model_employee,
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
        
        $tmpDataEmployees = Employee::find(['department', 'employee'])
        ->select(['employee.id', 'employee.firstname', 'employee.lastname', 'employee.profile_image_path', 'department.name', 'employee.email'])
        ->asArray()
        ->innerJoin('department', 'department.id = employee.department_id')->all();
        $employees = [];
         
        if (!empty($tmpDataEmployees)) {
        	foreach ($tmpDataEmployees as $tmpDataEmployee) {
        		$employees[] = [
        		'id' => $tmpDataEmployee['id'],
        		'fullname' => $tmpDataEmployee['firstname'] . ' '. $tmpDataEmployee['lastname'],
        		'department' => $tmpDataEmployee['name'],
        		'urlImage' => $tmpDataEmployee['profile_image_path'],
        		'email' => $tmpDataEmployee['email']
        		];
        	}
        }
        echo json_encode($employees);
    }
}
