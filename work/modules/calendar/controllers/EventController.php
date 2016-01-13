<?php
/**
 * @author minh-tha
 * @create date 2016-01-06
 */
namespace work\modules\calendar\controllers;

use common\models\work\Invitation;

use Yii;
use common\models\calendar\event;
use work\modules\calendar\models\eventSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\controllers\CeController;
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
    	$model = new Invitation();
//         $searchModel = new eventSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
        $model = new eventSearch();
        return $this->render('index', [
        		'model' => $model,
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
     * @author          Le Nhan Hau
     * @created date    2015/01/13
     * 
     * get calendar
     */
    public function actionCalendar() {
        $this->layout=false;
        header('Content-type: application/json');
        $calendars = array(
            array(
                'title' => 'Long Event',
                'start' => '2016-01-04'
            )
        );
        echo json_encode($calendars);
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
}
