<?php

namespace app\controllers;

use app\models\Advices;
use app\models\AdvicesSearch;
use app\models\AdvicesStudentsSearch;
use app\models\Students;
use app\models\StudentsSearch;
use DateTime;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;


class SiteController extends Controller
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
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public static function dateFormation($date) {
        $formattedDate = (new DateTime($date))->format('j F, Y');

        $months = [
            'January' => 'Январь',
            'February' => 'Февраль',
            'March' => 'Март',
            'April' => 'Апрель',
            'May' => 'Май',
            'June' => 'Июнь',
            'July' => 'Июль',
            'August' => 'Август',
            'September' => 'Сентябрь',
            'October' => 'Октябрь',
            'November' => 'Ноябрь',
            'December' => 'Декабрь'
        ];

        return strtr($formattedDate, $months);
    }

    /**
     * Lists all Advices models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AdvicesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExport($id)
    {
        $searchStudents = new AdvicesStudentsSearch();
        $dataStudents = $searchStudents->search($this->request->queryParams)->getModels();

        $date = Advices::findOne($id)->date;

        $fileName = 'СП ' . $this->dateFormation($date) . '.csv';

        $text = 'Совет Профилактики ' . $this->dateFormation($date) . ';' . PHP_EOL;

        // var_dump(implode(';', $this->lable(array_keys($dataStudents[0]))));die;
        
        $text .= implode(';', $this->lable(array_keys($dataStudents[0]))) . PHP_EOL;
        
        foreach ($dataStudents as $fields) {
            $text .= implode(';', $fields) . PHP_EOL;
        }

        $response = Yii::$app->response;

        $response->headers->add('Content-Type', 'text/csv');
        $response->headers->add('Content-Disposition', "attachment; filename=$fileName");

        $response->sendContentAsFile(iconv('UTF-8', 'Windows-1251', $text), $fileName)->send();
    }

    public function lable($array)
    {
        $lable = [
            'dishes_title' => 'Название блюда',
            'products_title' => 'Название продукта',
            'category' => 'Категория продукта',
            'pre_processing' => 'Предварительная обработка продутка',
            'count_spices' => 'Количество пряных продуктов',
            'dishes_category' => 'Категория блюда',
            'priority' => 'Очередь добавления',
            'calorie' => 'Калорийность'
        ];

        foreach ($array as $key => $val) {
            foreach ($lable as $key2 => $val2) {
                if ($val == $key2) {
                    $array[$key] = $val2;
                    continue;
                }
            }
        }

        return $array;
    }
}
