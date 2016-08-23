<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Discipline;
use app\models\Teacher;
use app\models\News;
use app\models\Contain;
class DisciplineController extends Controller
{
    /*
    * запрашивает из модели запись дисциплины с номером $id
    * и выводит файл editDiscipline.php
    * после сохранения введенных данных вызвать метод actionDiscipline($id)
    * return -
    * обновление данных дисциплины
    */
    public function actionEdit($id) //work!
    {
        $discipline = Discipline::getDiscipline($id);
        $teacher=Teacher::getTeacher($discipline->intTeacherID);
        $news = "qweq"/*News::getNewsByTeacher($discipline->intTeacherID)*/;

       /*обработка принажатии кнопки*/
        if ($_POST['Discipline']) {
            
            $discipline->charInfo = $_POST['Discipline']['charInfo'];
            $discipline->charSpecial = $_POST['Discipline']['charSpecial'];
            if ($discipline->validate() && $discipline->save()) {
                return Yii::$app->response->redirect(['/discipline/view/'.$discipline->intDisciplineID]); 
            }
        }    
            return $this->render('editDiscipline', ['discipline' => $discipline,'teacher'=>$teacher]);
        
        
    }

    /*1-руководство, 2-методист, 3-преподаватель, 4-студент
    *actionList() – проверяет статус пользователя Yii::$app->user->identity->status и запрашивает 
    *в соответствии со статусом данные в $listDisciplines из модели Discipline: 
    *1.   если status(руководитель) == 1, то получить массив объектов 
    $listDisciplines методом getListDisciplines(); 
    *Если в переменной $_POST['Discipline'] появились данные, 
    вызвать метод Discipline::create() для создания новой записи в tblDisciplines,
    
    ?*2.   если status(методист) == 2, то получить массив объектов $listTeacher из модели Teacher 
    методом getListTeacher($id), 
    ?*где $id - идентификатор методиста в таблице tblMetodist(Yii::$app->user->identity->alterID), 
    *затем для каждого $id - ид преподавателя получить массивы Дисциплин 
    *методом getTeacherDiscipline($id - ид преподавателя) из модели Disicpline
    *3.   если status(преподаватель) == 3, то получить массив объектов $listDisciplines методом getTeacherDiscipline($id), 
    *где $id = Yii::$app->user->identity->alterID - ид преподавателя
    *4.   если status(студент) == 4, то получить массив объектов $listDisciplines методом getCourseDiscipline($courseId, $studentID),  
    *где $courseId = Yii::$app->user->identity->course - курс, на котором учится студент,
    * $studentID = Yii::$app->user->identity->alterID - id студента в tblStudent
    *5.   выводит файл listDisciplines.php с параметром $listDisciplines
    */
    public function actionList()
    {
        switch (Yii::$app->user->identity->status) {
            case 1: //work!
                { //boss

                    $discipline = new Discipline();
                    
                    $listDisciplines = Discipline::getListDisciplines();
                    if (isset($_POST['Discipline'])) {
                        $discipline->charName = $_POST['Discipline']['charName'];
                        $discipline->charInfo = $_POST['Discipline']['charInfo'];
                        if ($discipline->validate() && $discipline->save()) {
                            return Yii::$app->response->redirect(['/discipline/list']);   
                        }
                    }
                    return $this->render('listDisciplines', ['discipline' => $discipline,
                        'listdiscipline' => $listDisciplines]);
                    break;
                };
            case 2://методист
                { 
                /*
                получить массив объектов $listTeacher из модели Teacher методом getListTeacher($id), 
                где $id - идентификатор методиста в таблице tblMetodist(Yii::$app->user->identity->alterID), 
                */  //список преподов на опр кафедре (закреплен за методистом)
                    $listTeacher=Teacher::getMetodistDisciplines(Yii::$app->user->identity->alterID);
                    return $this->render('listDisciplines', ['listdiscipline' => $listTeacher]);
                    break;
                };
            case 3: //work!
                { //преподааватель
                    
                    $listDisciplines = Discipline::getTeacherDisciplin(Yii::$app->user->identity->alterID);
                    return $this->render('listDisciplines', ['discipline' => $discipline,'listdiscipline' => $listDisciplines]);
                    break;
                    
                };
            case 4: //work!
                { //студент

                    $listDisciplines = Discipline::getCourseDisciplines(Yii::$app->user->identity->course, Yii::$app->user->identity->alterID);

                    return $this->render('listDisciplines', ['listdiscipline' => $listDisciplines]);
                };
            default:{
                return Yii::$app->response->redirect(['site/login']);
                break;
            }
        }
    }
    /*
    *запрашивает из модели запись дисциплины $discipline с номером $id;
    *для номера преподавателя $discipline['intTeacherID'] получить из модели News список новостей в $news 
    *методом getNewsByTeacher($discipline['intTeacherID']); 
    *$discipline - ассоциативный массив с полями: intDisciplineID, charName, charInfo, charSpecial, intCourseID, intTeacherID, 
    *charTeacherName, charTeacherSurname, charTeacherSecondName, charEmail, charChair
    *$news - массив с целочисленными ключами, по значению которых, равным intNewsID, хранятся ассоциативные массивы с полями: 
    *intNewsID, charText, datDate
    *Вывести файл discipline.php с параметрами $discipline, $news 
    *Входные параметры: $id - номер записи в tblDiscipline
    *Возвращаемые параметры: нет
    */
    public function actionView($id) //work!
    {
        $discipline = Discipline::getDiscipline($id);
        $teacher = Teacher::getTeacher($discipline->intTeacherID);
        $news = News::getNewsByTeacher($discipline->intTeacherID);
        return $this->render('discipline', ['discipline' => $discipline, 'teacher'=>$teacher, 'news' => $news]);

    }
    /*
    *Получает данные для новой записи в таблице tblContain, 
    *создает объект таблицы tblContain $contain и передает их в модель Contain методу create($contain), 
    *обновляет страницу discipline.php для студента;
    *Входные параметры: $studentId - Id студента, который сделал выбор дисциплины(Yii::$app->user->identity->alterID); 
    *$courseId - Id курса, на котором обучается студент(Yii::$app->user->identity->course); 
    *$disciplineId - Id дисциплины, которую выбрал студент(intDisciplineID)
    , 
    *Возвращаемые параметры: нет
    id - intDisciplineID
    */
    public function actionSignin($id)
    {

        if ((Yii::$app->user->isGuest) OR (Yii::$app->user->identity->status != 4) ) {
            return Yii::$app->response->redirect(['site/login']);
        }
        $contain = new Contain();
        $contain->intStudentsID = Yii::$app->user->identity->alterID;
        $contain->intCourseID = Yii::$app->user->identity->course;
        $contain->intDisciplineID = $id;        
        if($contain->save()){
            return Yii::$app->response->redirect(['/discipline/list']); 

        }
    }

}