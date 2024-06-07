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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        $dataStudents = $searchStudents->exportData($id);

        $date = Advices::findOne($id)->date;
        $length_table = count($dataStudents[0]);    
        $columnLetter = $this->getExcelColumnLetter($length_table);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Совет Профилактики ' . $this->dateFormation($date));
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A1:' . $columnLetter . '1');

        $column = 'A';
        foreach ($this->lable(array_keys($dataStudents[0])) as $header) {
            $sheet->setCellValue($column.'2', $header);
            $column++;
        }

        $row = 3;
        foreach ($dataStudents as $rowData) {
            $column = 'A';
            foreach ($rowData as $cellData) {
                $sheet->setCellValue($column.$row, $cellData);
                $column++;
            }
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

        $writer = new Xlsx($spreadsheet);

        $filename =  'СП ' . $this->dateFormation($date) . '.xlsx';
        
        $tempFilePath = Yii::getAlias('@app/runtime/' . $filename);
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

    public function lable($array)
    {
        $lable = [
            'id' => 'ID',
            'advices_id' => 'Advices ID',
            'students_id' => 'Students ID',
            'fio' => 'ФИО',
            'birthday' => 'День рождения',
            'group' => 'Группа',
            'groups_id' => 'Группа',
            'curator' => 'Куратор',
            'reason' => 'Причина вызова на СП',
            'result' => 'Результат СП',
            'protocol' => 'Протокол',
            'decree' => 'Приказ',
            'remark' => 'Замечание',
            'reprimand' => 'Выговор',
            'note' => 'Примечание',
            'liquidation_period' => 'Срок ликвидации',
            'memo' => 'Служебная записка от куратора',
            'date' => 'Дата СП',
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
