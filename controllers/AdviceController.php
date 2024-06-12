<?php

namespace app\controllers;

use app\models\Advices;
use app\models\AdvicesSearch;
use app\models\AdvicesStudentsSearch;
use app\models\Users;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdviceController implements the CRUD actions for Advices model.
 */
class AdviceController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Displays a single Advices model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchStudents = new AdvicesStudentsSearch();
        $dataStudents = $searchStudents->search($id, $this->request->queryParams);

        return $this->render('view', [
            'dataAdvice' => $this->findModel($id),
            'dataStudents' => $dataStudents,
            'searchStudents' => $searchStudents,
        ]);
    }

    /**
     * Creates a new Advices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest || Users::findOne(Yii::$app->user->id)->getTitleRoles() !== 'Admin') {
            return $this->goHome();
        }

        $model = new Advices();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->validate() && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Advices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest || Users::findOne(Yii::$app->user->id)->getTitleRoles() !== 'Admin') {
            return $this->goHome();
        }

        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Advices model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest || Users::findOne(Yii::$app->user->id)->getTitleRoles() !== 'Admin') {
            return $this->goHome();
        }
        
        $this->findModel($id)->delete();

        return $this->redirect(['/']);
    }

    /**
     * Finds the Advices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Advices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advices::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
