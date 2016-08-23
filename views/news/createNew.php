<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    if (Yii::$app->user->isGuest)
    {
    	return Yii::$app->response->redirect(['news/last']);
    } 
    else if(Yii::$app->user->identity->status !== 1)
    {
    	if (Yii::$app->user->identity->status !== 3)
    	{
    		return Yii::$app->response->redirect(['news/last']);
    	}
    }
?>
<h1>Новое объявление</h1>
<?php $form = ActiveForm::begin(); ?>
<div >
	
		<?= $form->field($new, 'charText')->textInput(['autofocus' => true])->textArea(['rows' => 6])?>
	
	
		<?= Html::submitButton('Создать', ['class' => 'button']) ?>
	
</div>
<?php ActiveForm::end(); ?>

