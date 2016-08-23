<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
	if (Yii::$app->user->isGuest)
	{
		return Yii::$app->response->redirect(['site/login']);
	}
if (Yii::$app->user->identity->status == 4 ){
	return Yii::$app->response->redirect(['site/index']);
}
?>
<ol>
<?php foreach($listStudents as $item): ?>
<li>
    <?php echo $item->charSurname." ".
        $item->charName." ".
        $item->charSecondName." ".
        
        $item->charGroup; ?>
</li>
<?php endforeach ?>
</ol>