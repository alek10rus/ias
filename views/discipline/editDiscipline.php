<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

if (Yii::$app->user->isGuest) {
    return Yii::$app->response->redirect(['/site/login']);
}
if (Yii::$app->user->identity->status == 1) {
    //на главную
    return Yii::$app->response->redirect(['/site/index']);
}
if (Yii::$app->user->identity->status == 4){
    return Yii::$app->response->redirect(['/site/index']);
}
?>
<?php /*$form = ActiveForm::begin(); ?>
<?php 
    $items = ArrayHelper::map($listTeacher,'TeacherID','TeacherName');
        $params = [
            'prompt' => 'Укажите преподавателя'
        ];
?>
"Эксперемент с выпадающим списком
Исход: невозможно получить полное имя в списке, так же не была сделана обработка этих изменений"

    <?=$form->field($discipline, 'TeacherID')->dropDownList($items,$params)->label('Преподаватель'); ?>

    <h2>
		<?= $form->field($discipline, 'charName')->label('Название дисциплины') ?>
    </h2>
<?php  ActiveForm::end(); */?>

<h3>
ФИО Преподавателя: <?php
echo $teacher->charSurname . " " . $teacher->charName . " " . $teacher->
    charSecondName;
?></h3>
<?php $form = ActiveForm::begin(); ?>
    

    <h2>
		<?= $form->field($discipline, 'charInfo')->textarea(['rows' => 5, 'cols' => 5])->label('Анотация') ?>
    </h2>

    <h2>
		<?= $form->field($discipline, 'charSpecial')->textarea(['rows' => 5, 'cols' => 5])->label('Дополнительно') ?>
    </h2>
    
        <div style="float:right">
        
		<?= Html::submitButton('Сохранить', ['class' => 'button','name' => 'save-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>
 
<?php
/*
1.  Если пользователь не авторизован перенаправить на страницу авторизации 
(return Yii::$app->response->redirect(['site/login']);)
2.  Если Yii::$app->user->identity->status !== 3(преподаватель) или !== 1(руководство), то перенаправить на главную
3.	Получить данные от контроллера DisciplineController в $discipline - ассоциативный массив с полями: 
intDisciplineID, intTeacherID, intCourseID, charName, charInfo, charSpecial
4.	Если имеются данные, то вывести извлеченные данные на страницу в форму. Использовать формы Yii2
5.  Вывести кнопку "Сохранить", которая передает форму методом POST в метод actionEdit.
*/

?>
