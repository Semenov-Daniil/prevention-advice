<?php

namespace app\controllers;

use app\models\Advices;
use app\models\AdvicesSearch;
use app\models\AdvicesStudentsSearch;
use app\models\Roles;
use app\models\Students;
use app\models\StudentsSearch;
use app\models\Users;
use DateTime;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

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

     /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Users();

        if ($this->request->isPost) {
            $data = Yii::$app->request->post()['Users'];

            $model->load($data, '');
            $model->validate();

            if (!$model->hasErrors()) {
                $user = Users::findOne(['login' => $model->login]);

                if (!empty($user) && $user->validatePassword($model->password)) {
                    $model = $user;
                    $model->token = Yii::$app->security->generateRandomString();
    
                    while(!$model->save()) {
                        $model->token = Yii::$app->security->generateRandomString();
                    }

                    Yii::$app->user->login($model);

                    return $this->goBack();
                } else {
                    $model->addError('password', 'Неправильное имя пользователя или пароль.');
                }
            }
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Register action.
     *
     * @return Response
     */
    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Users();
        $model->scenario = Users::SCENARIO_REGISTER;

        if ($this->request->isPost) {
            $data = Yii::$app->request->post()['Users'];

            $model->load($data, '');
            $model->validate();

            if (!$model->hasErrors()) {
                $model->roles_id = Roles::findOne(['title' => 'User'])->id;

                $model->token = Yii::$app->security->generateRandomString();
                while(!$model->validate()) {
                    $model->token = Yii::$app->security->generateRandomString();
                }

                $model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);

                $model->save(false);

                Yii::$app->user->login($model);

                return $this->goHome();
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            $identity = Yii::$app->user->identity;
            $user = Users::findOne($identity->id);
            $user->token = null;
            $user->save(false);
            Yii::$app->user->logout();
        }
        return $this->goHome();
    }

    public static function dateFormation($date) {
        $formattedDate = (new DateTime($date))->format('j F, Y');

        $months = [
            'January' => 'Января',
            'February' => 'Февраля',
            'March' => 'Марта',
            'April' => 'Апреля',
            'May' => 'Мая',
            'June' => 'Июня',
            'July' => 'Июля',
            'August' => 'Августа',
            'September' => 'Сентября',
            'October' => 'Октября',
            'November' => 'Ноября',
            'December' => 'Декабря'
        ];

        return strtr($formattedDate, $months);
    }

    public function actionExport($id)
    {
        $searchStudents = new AdvicesStudentsSearch();
        $dataStudents = $searchStudents->exportData($id);

        $table_title = ['№п/п', 'ФИО', 'Дата рождения', 'Группа', 'Куратор', 'Причина вызова на СП', 'Результат совета профилактики', 'Протокол', 'Приказ', 'Замечание', 'Выговор', 'Примечание', 'Срок ликвидации', 'Служебная записка от куратора'];
        $date = Advices::findOne($id)->date;
        $length_table = count($table_title);    
        $columnLetter = $this->getExcelColumnLetter($length_table);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

        $sheet->setCellValue('A1', 'Совет Профилактики ' . $this->dateFormation($date));
        $sheet->getStyle('A1')->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_BOTTOM);
        $sheet->getStyle('A1')->getFont()
            ->setBold(true)
            ->setSize(18);
        $sheet->mergeCells('A1:' . $columnLetter . '1');

        $column = 'A';
        foreach ($table_title as $header) {
            $sheet->setCellValue($column.'2', $header);
            $sheet->getStyle($column.'2')->getFont()
                ->setBold(true)
                ->setSize(12);
            $sheet->getStyle($column.'2')->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            $column++;
        }

        $row = 3;
        foreach ($dataStudents as $rowData) {
            $column = 'A';
            foreach ($rowData as $key=>$cellData) {
                $sheet->setCellValue($column.$row, $cellData);
                $sheet->getStyle($column.$row)->getAlignment()
                    ->setVertical(Alignment::VERTICAL_BOTTOM)
                    ->setWrapText(true);

                if ($key == 'birthday') {
                    $spreadsheet->getActiveSheet()->getStyle($column.$row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
                }

                $column++;
            }
            $sheet->getRowDimension($row)->setRowHeight(-1);
            $row++;
        }

        for ($i = 'A'; $i <= $columnLetter; $i++) {
            $sheet->getColumnDimension($i)->setAutoSize(true);
        }
            
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A1:' . $columnLetter . (2 + count($dataStudents)))->applyFromArray($styleArray);

        $sheet->setAutoFilter('A2:' . $columnLetter . (2 + count($dataStudents)));

        $writer = new Xlsx($spreadsheet);

        $filename =  'СП ' . $this->dateFormation($date) . '.xlsx';
        $dir = Yii::getAlias('@app/advices_files/');

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        
        $tempFilePath = $dir . $filename;
        $writer->save($tempFilePath);

        Yii::$app->response->sendFile($tempFilePath)->send();
    }

    function getExcelColumnLetter($columnNumber) {
        $columnLetter = '';
        
        while ($columnNumber > 0) {
            $columnNumber--;
            $columnLetter = chr($columnNumber % 26 + 65) . $columnLetter;
            $columnNumber = (int)($columnNumber / 26);
        }
        
        return $columnLetter;
    }
}
