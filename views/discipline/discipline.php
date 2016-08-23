<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
 <?php 
 if (Yii::$app->user->isGuest){
   return Yii::$app->response->redirect(['site/login']); 
}?>
<h2 style="font-weight:bold">
<?php
echo $discipline->charName; ?> </h2>

<h3 > 
ФИО Преподавателя: 
    <?php   //ФИО
        echo    $teacher->charSurname." ". $teacher->charName." ". $teacher->charSecondName;
    ?>

</h3> 
<?php if((Yii::$app->user->identity->status == 2) or (Yii::$app->user->identity->status == 3)):?>
    <button><a  class="button"  href="/discipline/edit/<?php echo $discipline->intDisciplineID;?>">Редактировать</a></button>    
<?php endif ?>       

<h2 style="font-weight:bold">Аннотация</h2>
<div>
    <?php 
        echo  $discipline->charInfo;
    ?>
</div>
<h2 style="font-weight:bold">Дополнительно</h2>
<div>
    <?php 
        echo  $discipline->charSpecial;
    ?>
</div>
<h2 style="font-weight:bold">Объявления</h2>
    <?php if(Yii::$app->user->identity->status == 3):?>
        <a  class="button"  href="/news/create"><button>Добавить</button></a>
    <?php endif ?>  
<ul>
<?php foreach ($news as $item): ?>
    <li>
        <?php echo $item->datDate; ?>
    </li>
    <div>
        <?php echo $item->charText; ?>
    </div>
    <br />

<?php endforeach ?>

</ul>




