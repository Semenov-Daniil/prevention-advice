<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\Users;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => 'Совет Профилактики',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);

    if (Yii::$app->user->isGuest) {
        $item = [
            ['label' => 'Регистрация', 'url' => ['/site/register'], 'options' => ['class' => 'ml-auto']],
            ['label' => 'Вход', 'url' => ['/site/login']]
        ];
    } else {
        if(Users::findOne(Yii::$app->user->id)->getTitleRoles() == 'Admin') {
            $item = [
                ['label' => 'Кураторы', 'url' => ['/curator/index']],
                ['label' => 'Группы', 'url' => ['/group/index']],
                ['label' => 'Студенты', 'url' => ['/student/index']],
                ['label' => 'Пользователи', 'url' => ['/user/index']],
            ];
        }

        $item[] = ['label' => 'Выход (' . Yii::$app->user->identity->login . ')', 'url' => ['/site/logout'], 'options' => ['class' => 'ml-auto']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav w-100 d-flex'],
        'items' => $item
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget([
                    'homeLink' => ['label' => 'Совет Профилактики', 'url' => '/'],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
