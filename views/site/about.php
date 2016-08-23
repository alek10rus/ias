<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php switch (Yii::$app->user->identity->status){
            case 4 : {echo 'Вы зашли как Студент'; break;}
            case 2 : echo 'Вы зашли как Методист'; break;
            default: echo 'Вы зашли как Гость';
            }
        ?>
        <?= Yii::$app->user->identity->name ?>
        <?php if (Yii::$app->user->isGuest)
            return Yii::$app->response->redirect(['site/login']);
        ?>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>
</div>
