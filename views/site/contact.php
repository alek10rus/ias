<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Связь с администратором';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
	
	<div style = "padding-top: 1vw;">
		<?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>
			<div class="alert alert-success">
				Спасибо за отправку сообщения!
			</div>
		<?php else: ?>
		<div class="row">
            <div class="col-lg-12">
                <?php $form = ActiveForm::begin([
					'id' => 'contact-form'
				]); ?>
                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>
                    <?= $form->field($model, 'email') ?>
                    <?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
		<?php endif; ?>
	</div>
</div>
