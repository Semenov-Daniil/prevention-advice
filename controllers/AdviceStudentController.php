<?php

namespace app\controllers;

use app\models\Advices;
use app\models\AdvicesStudents;
use app\models\AdvicesStudentsSearch;
use app\models\Students;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdviceStudentController implements the CRUD actions for AdvicesStudents model.
 */
class AdviceStudentController extends Controller
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
     * Lists all AdvicesStudents models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AdvicesStudentsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdvicesStudents model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AdvicesStudents model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($advice)
    {
        $model = new AdvicesStudents();
        $dataAdvice = Advices::findOne($advice);

        if ($this->request->isPost) {
            $data = ($this->request->post())['AdvicesStudents'];

            if ($model->load($data, '')) { 
                if (empty($student = Students::find()->where(['fio' => $data['fio'], 'birthday' => $data['birthday'], 'groups_id' => $data['groups_id']])->asArray()->all())) {
                    $student = new Students();
                    $student->load($data, '');
                    $student->save();
                    $students_id = $student->id;
                } else {
                    $students_id = $student[0]['id'];
                }

                $model->advices_id = $advice;
                $model->students_id = $students_id;

                if ($model->save()) {
                    return $this->redirect(['advice/view', 'id' => $advice]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'dataAdvice' => $dataAdvice,
        ]);
    }

    /**
     * Updates an existing AdvicesStudents model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $data = ($this->request->post())['AdvicesStudents'];

            if ($model->load($data, '')) { 
                if (empty($student = Students::find()->where(['id' => $model->students_id, 'fio' => $data['fio'], 'birthday' => $data['birthday'], 'groups_id' => $data['groups_id']])->asArray()->all())) {
                    $student = new Students();
                    $student->load($data, '');
                    $student->save();
                    $students_id = $student->id;
                } else {
                    $students_id = $student[0]['id'];
                }

                $model->students_id = $students_id;

                if ($model->save()) {
                    return $this->redirect(['advice/view', 'id' => $model->advices_id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AdvicesStudents model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AdvicesStudents model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AdvicesStudents the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = AdvicesStudents::find()
            ->select([
                '{{%advices_students}}.id',
                'advices_id',
                'date as advice_date',
                'students_id',
                '{{%students}}.fio as fio', 
                '{{%students}}.birthday', 
                '{{%groups}}.id as groups_id', 
                '{{%groups}}.title as group', 
                '{{%curators}}.fio as curator',
                'reason',
                'result',
                'protocol',
                'decree',
                'remark',
                'reprimand',
                'note',
                'liquidation_period' ,
                'memo',
            ])
            ->innerJoin('{{%advices}}', '{{%advices}}.id = {{%advices_students}}.advices_id')
            ->innerJoin('{{%students}}', '{{%students}}.id = {{%advices_students}}.students_id')
            ->innerJoin('{{%groups}}', '{{%groups}}.id = {{%students}}.groups_id')
            ->innerJoin('{{%curators}}', '{{%curators}}.id = {{%groups}}.curators_id')
            ->where(['{{%advices_students}}.id' => $id])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
