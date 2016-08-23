<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Contain;

class ContainController extends Controller
{
    /*
    actionDisciplines() � ����������� �� ������ Contain ������ ���������, 
    ��������� ��������� ������� getChosenDisciplines(), 
    ������� ����
     contain/chosenDisciplines.php � ���������� $listDisciplines
    ������� ���������: ���
    ������������ ���������: ���
    */
    public function actionDisciplines() { //done
	   $listDisciplines = Contain::getChosenDisciplines();
	   return $this->render('chosenDisciplines', ['listDisciplines' => $listDisciplines]);
    }
    
	/*
    actionStudents() � ����������� �� ������ Contain ������ ���������, 
    ��������� ��������� ������� getStudentMadeChoice(), ������� ����
    contain/listStudents.php � ���������� $listStudents
    $listStudents - ������ � �������������� �������, 
    �� �������� �������, ������ intStudentID, �������� ������������� ������� � ������: 
    intStidentID, charName, charSurname, charSecondName, intGroup, disciplines[]; 
    disciplines[] - ������ ���������,  ��������� ���������, � ������� ������ �������� intDisciplineID, � �������� ���� charName.
    ������� ���������: ���
    ������������ ���������: ���
    */
	public function actionStudents() { //done
		$listStudents = Contain::getStudentMadeChoice();
		return $this->render('listStudents',['listStudents' => $listStudents]);
        
	}
    
	/*
    actionDispStudents($dispId) � ����������� �� ������ Contain ������ ���������, 
    ��������� ��������� ������� getStudentsForDiscipline($dispId), ������� ����
    contain/listStudents.php � ���������� $listStudents
    $listStudents - ������ �������� ������ Student
    ������� ���������: ���
    ������������ ���������: ���
    */
    
	public function actionDispstudents($id) {
	    $listStudents = Contain::getStudentsForDiscipline($id);
		return $this -> render('listStudents', ['listStudents' => $listStudents]);
        
	}
}