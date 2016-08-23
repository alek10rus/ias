<?php

namespace app\models;

use Yii;
class Contain extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'tblContain';
    }
	

    public function rules()
    {
        return [
            [[ 'intStudentsID', 'intCourseID', 'intDisciplineID'], 'required'],
            [[ 'intStudentsID', 'intCourseID', 'intDisciplineID'], 'integer'],
        ];
    }
	

    public function attributeLabels()
    {
        return [
            'intContainID' => 'Номер связи',
            'intStudentsID' => 'Номер студента',
            'intCourseID' => 'Номер курса',
            'intDisciplineID' => 'Номер дисциплины',
        ];
    }
	/*
    возвращает массив объектов класса Student,
    у которых в tblCourse номер студента $studId соответствует   'intCourseID' => 'ID курса', 'intNCourse' => 'Номер курса',
    номеру дисциплины $discId
    Входные параметры: $discId - номер дисциплины в таблице tblContain
    Возвращаемые параметры: $listStudents - массив объектов класса Student*/
	public static function getStudentsForDiscipline($id)
	{
	   //в масив объектов класса студент из табл курс получить записи где $studId соответсвует $discId
       //для этого стоит получить из тбл контейн id курса получить список студентов
		$listContain = self::find()->where(['intDisciplineID' => $id])->all(); //         
        
        $listStudents=array();
        $i=1;
        foreach ($listContain as $data):
            $listStudents[$i]=Student::getStudent($data->intStudentsID); 
            $i++;
        endforeach; 
		return $listStudents;
	}
	/*
    возвращает массив записей студентов,
    для которых в tblContain есть соответствующие записи.
    Входные параметры: нет
    Возвращаемые параметры: $listStudents - массив с целочисленными ключами, 
    по значению которых, равным intStudentID, хранятся ассоциативные массивы с полями: 
    intStudentID, charName, charSurname, charSecondName, intGroup, disciplines[]; 
    disciplines[] - массив дисциплин,  выбранных студентом, в котором ключом является intDisciplineID, и хранится поле charName.
 */
    public static function getStudentMadeChoice()//done
    {
	   
	   $containList=self::find()->all();
       $listStudents= array();
       $i=1;
       foreach ($containList as $data):
         $listStudents[$i++]= Student::getStudent($data->intStudentsID); 
       endforeach;
	   return $listStudents;
		
	}
	/*
    возвращает массив объектов таблицы tblDiscipline, 
    для которых в tblContain есть соответствующие записи, записи не должны повторяться
    Входные параметры: нет
    Возвращаемые параметры: $listDisciplines - массив с целочисленными ключами,
    по значениям которых хранятся объекты класса Discipline
    с полями intDisciplineID, intTeacherID, intNCourse, 
    charName, charTeacherName, charTeacherSurname, charChair, countStudents*/
	public static function getChosenDisciplines()//done
	{
        $containList=self::find()->groupBy('intDisciplineID')->all();
        $listDisciplines = array();
        $i=1;
        foreach ($containList as $data):
            $listDisciplines[$i++]= Discipline::getDiscipline($data->intDisciplineID);
        endforeach;
        return $listDisciplines;
	}
    /* 
    Функция возвращает true если в таблице tblContain если студент с $StudentID записан на дисциплину с $DisciplineID иначе false
    Входные параметры: $StudentID - идентификатор студента из таблици tblStudent,
    $DisciplineID - идентификатор дисциплины из таблици tblDiscipline
    Возвращаемые параметры: true - студент записан false - студент не записан
    */
    public static function сheckStudent($StudentID, $DisciplineID)
    {
        $model = self::find()->where(['intStudentsID' => $StudentID, 'intDisciplineID' => $DisciplineID])->one();
        if($model){
            return true;
        } else {
            return false;
        }
        
    }
    
	public function create($contain) 
	{
		if ($contain->save())
		{
			return true;
		}
		$contain->delete();
		$contain->addError('charText', 'Ошибка при создании новой записи. Попробуйте снова.');
		return false;
	}
}	