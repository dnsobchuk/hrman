<?php

namespace app\controllers;

use app\forms\InterviewJoinForm;
use app\forms\InterviewMoveForm;
use app\forms\InterviewRejectForm;
use app\forms\InterviewUpdateForm;
use app\services\StaffService;
use Yii;
use app\models\Interview;
use app\forms\search\InterviewSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InterviewController implements the CRUD actions for Interview model.
 */
class InterviewController extends Controller
{
    private $staffService;

    public function __construct($id, $module, StaffService $staffService, $config = [])
    {
        $this->staffService = $staffService;
        parent::__construct($id, $module, $config);
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Interview models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InterviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Interview model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Interview model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionJoin()
    {
        $form = new InterviewJoinForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $interview = $this->staffService->joinToInterview($form);
            return $this->redirect(['view', 'id' => $interview->id]);
        }
        return $this->render('join', ['joinForm' => $form]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionMove($id)
    {
        $interview = $this->findModel($id);
        $form = new InterviewMoveForm($interview);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->staffService->moveInterview($interview, $form);
            return $this->redirect(['view', 'id' => $interview->id]);
        }
        return $this->render('move', [
            'moveForm' => $form,
            'model' => $interview,
        ]);
    }

    /**
     * Updates an existing Interview model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $interview = $this->findModel($id);
        $form = new InterviewUpdateForm($interview);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->staffService->updateInterview($interview, $form);
            return $this->redirect(['view', 'id' => $interview->id]);
        }
        return $this->render('update', [
            'updateForm' => $form,
            'model' => $interview,
        ]);
    }

    /**
     * Reject an existing Interview model.
     * If reject is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionReject($id)
    {
        $interview = $this->findModel($id);
        $form = new InterviewRejectForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->staffService->rejectInterview($interview, $form);
            return $this->redirect(['view', 'id' => $interview->id]);
        }
        return $this->render('reject', [
            'rejectForm' => $form,
            'model' => $interview,
        ]);
    }

    /**
     * Deletes an existing Interview model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Interview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Interview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Interview::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
