<?php 
	use yii\helpers\Html;
	if (Yii::$app->user->isGuest)
	{
		return Yii::$app->response->redirect(['site/login']);
	} else if((Yii::$app->user->identity->status === 1 || 
            Yii::$app->user->identity->status === 3) && $mode)
    {
    	echo '<p style="text-align: center;"><button>'.Html::a('Создать новое объявление', ['news/create'],['class' => 'button']).'</button></p>';
	}
?>
<?php foreach($news as $new): ?>
	<h4 class="news_header"><?= substr($new->datDate, 0, 10).' ' ?> <a><?= $new->charName.' '.$new->charSurname?></a></h4>
	<p class="news_text" style="padding-left: 25pt;"><?= $new->charText ?></p>
<?php endforeach ?>