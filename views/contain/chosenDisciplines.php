<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
	if (Yii::$app->user->isGuest)
	{
		return Yii::$app->response->redirect(['site/login']);
	}

if(	Yii::$app->user->identity->status == 1 or  Yii::$app->user->identity->status == 4)
{
	//return Yii::$app->response->redirect(['site/index']);
}	

?>
<ol>
<?php foreach($listDisciplines as $item): ?>
<li>
    <?php echo $item->charName ;?>
		
</li>
<?php endforeach ?>
</ol>

