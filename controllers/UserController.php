<?php

namespace app\controllers;

use app\models\Users;
use app\models\UsersSearch;
use yii\web\NotFoundHttpException;
use Yii;

class UserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest || Users::findOne(Yii::$app->user->id)->getTitleRoles() !== 'Admin') {
            return $this->goHome();
        }
        
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->user->id, $this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest || Users::findOne(Yii::$app->user->id)->getTitleRoles() !== 'Admin') {
            return $this->goHome();
        }

        $model = $this->findModel($id);

        if ($this->request->isPost) {

            $data = Yii::$app->request->post()['Users'];

            $model->roles_id = $data['roles_id'];

            $model->save(false);

            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        $model = Users::find()
            ->select([
                '{{%users}}.id', 'login', 'roles_id', 'title as role'
            ])
            ->innerJoin('{{%roles}}', '{{%roles}}.id = {{%users}}.roles_id')
            ->where(['{{%users}}.id' => $id])
            ->one();

        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
