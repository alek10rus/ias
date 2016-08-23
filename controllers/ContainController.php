<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Contain;

class ContainController extends Controller
{
    /*
    actionDisciplines() Ц запрашивает из модели Contain список дисциплин, 
    выбранных студентом методом getChosenDisciplines(), 
    выводит файл
     contain/chosenDisciplines.php с параметром $listDisciplines
    ¬ходные параметры: нет
    ¬озвращаемые параметры: нет
    */
    public function actionDisciplines() { //done
	   $listDisciplines = Contain::getChosenDisciplines();
	   return $this->render('chosenDisciplines', ['listDisciplines' => $listDisciplines]);
    }
    
	/*
    actionStudents() Ц запрашивает из модели Contain список студентов, 
    выбранных студентом методом getStudentMadeChoice(), выводит файл
    contain/listStudents.php с параметром $listStudents
    $listStudents - массив с целочисленными ключами, 
    по значению которых, равным intStudentID, хран€тс€ ассоциативные массивы с пол€ми: 
    intStidentID, charName, charSurname, charSecondName, intGroup, disciplines[]; 
    disciplines[] - массив дисциплин,  выбранных студентом, в котором ключом €вл€етс€ intDisciplineID, и хранитс€ поле charName.
    ¬ходные параметры: нет
    ¬озвращаемые параметры: нет
    */
	public function actionStudents() { //done
		$listStudents = Contain::getStudentMadeChoice();
		return $this->render('listStudents',['listStudents' => $listStudents]);
        
	}
    
	/*
    actionDispStudents($dispId) Ц запрашивает из модели Contain список студентов, 
    выбранных студентом методом getStudentsForDiscipline($dispId), выводит файл
    contain/listStudents.php с параметром $listStudents
    $listStudents - массив объектов класса Student
    ¬ходные параметры: нет
    ¬озвращаемые параметры: нет
    */
    
	public function actionDispstudents($id) {
	    $listStudents = Contain::getStudentsForDiscipline($id);
		return $this -> render('listStudents', ['listStudents' => $listStudents]);
        
	}
}