<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/*
2.	Если Yii::$app->user->identity->status === 1(Руководитель) Вывести кнопки "Список студентов" с ссылкой на метод контроллера ContainController
actionStudents и «Список дисциплин» с ссылкой на метод ContainController actionDisciplines, получить объект класса Discipline в переменную
$discipline(Объекс Discipline с полями, соответствующими названиям полей таблицы tblDiscipline)
вывести форму для создания новой дисциплины $discipline
6.	Если Yii::$app->user->identity->status  == 2(методист) или == 3(преподаватель) - Напротив каждой дисциплины вывести кнопку «Студенты»,
кнопка ссылается на метод контроллера ContainController.php actionStudents с параметром intDisciplineID
7.  Если Yii::$app->user->identity->status  == 4(студент) Если студент еще не записался на дисциплину
(в $listDisciplines[intDisciplineID]->$contain == false) - то:
напротив дисциплины вывести кнопку «Записаться», иначе напротив этой дисциплины вывести "Записан". 
Кнопка "Записаться" вызывает скрипт контроллера DisciplineController, actionSignIn с параметрами: 
Yii::$app->user->identity->alterID, 
Yii::$app->user->identity->course, 
$listDisciplines[intDisciplineID]->intDisciplineID.
*/
?>
<div style="text-align: center;"> <a style="color: blue;" href="/site/rules">Правила выбора дисциплин</a></div> 
<?php if (Yii::$app->user->identity->status == 1): ?>
    <?php $form = ActiveForm::begin(); ?>
    <h2>
		<?= $form->field($discipline, 'charName')->label('Название дисциплины') ?>

		<?= $form->field($discipline, 'charInfo')->textarea(['rows' => 5, 'cols' => 5])->label('Анотация') ?>
        <div style="float:right">
            <?= Html::submitButton('Добавить', ['name' => 'addDiscipline']) ?>
        </div>
    </h2>
    <?php ActiveForm::end(); ?>
<?php endif; ?>
<?php if(Yii::$app->user->identity->status == 2): ?>
    <div style="text-align: center;"> <a href="/contain/disciplines/"> <button>Список дисциплин</button></a></div>
<?php endif; ?>
    <table  border="1" cellpadding="10" style="font-size: x-large" >

     <tr>
        <td>Название дисциплины</td> 
        <td>Преподаватель </td> 
        <td>Кафедра </td> 
        <td></td> 
     </tr>
        <?php foreach ($listdiscipline as $item): ?>
        <tr>  
            <td > 
                <a href="/discipline/view/<?php echo $item->DisciplineID ?>" > <?php echo $item->Name; ?> </a>
            </td>
            
            <td > 
                <?php echo $item->TeacherSurname . " " . $item->TeacherName . " " . $item->TeacherSecondName; ?> 
            </td>
            
            <td > 
                <?php echo $item->Chair; ?> 
            </td>
            
            <?php if (Yii::$app->user->identity->status != 4): ?>   
            <td>
                <button><a class="button" href="/contain/dispstudents/<?php echo $item->DisciplineID; ?>">Список студентов</a></button>
            </td>
            <?php endif ?> 
            
            <?php if ((Yii::$app->user->identity->status == 4)AND($item->contain))
            {
                echo "<td>Записан(а)</td>";
            } 
            ?>
            <?php if ((Yii::$app->user->identity->status == 4)AND($item->contain==false)): ?>
                <td>
                    <a href="/discipline/signin/<?php echo $item->DisciplineID; ?>"><button>Записаться</button></a>
                </td>
            <?php endif?>    
        </tr>
        <?php endforeach; ?>
</table>

