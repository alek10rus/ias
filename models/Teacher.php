<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tblTeacher}}".
 *
 * @property integer $intTeacherID
 * @property string $charSurname
 * @property string $charName
 * @property string $charSecondName
 * @property string $charLogin
 * @property string $charPassword
 * @property string $charEMail
 * @property string $charChair
 */
class Teacher extends \yii\db\ActiveRecord
{
    public $DisciplineID;
    public $TeacherID;
    public $CourseID;
    public $Name;
    public $Info;
    public $Special;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblTeacher';;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['charSurname', 'charName', 'charSecondName', 'intID', 'charEMail', 'charChair', 'intMetodistID'], 'required'],
            [['charSurname', 'charName', 'charSecondName', 'charEMail', 'charChair'], 'string', 'max' => 256],
			[['intID', 'intMetodistID'], 'integer'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intTeacherID' => 'Номер преподавателя',
            'charSurname' => 'Фамилия преподавателя',
            'charName' => 'Имя преподавателя',
            'charSecondName' => 'Отчество преподавателя',
            'intID' => 'Ссылка на сводную таблицу',
            'charEMail' => 'Электронный адрес преподавателя',
            'charChair' => 'Кафедра перподавателя',
            'intMetodistID' => 'Номер методиста преподавателя',
        ];
    }
    
	public static function getTeacher($id) {
		$teacher = self::find() -> where(['intTeacherID'=>$id]) -> one();
		return $teacher;
	}
	/*
    */
	public static function getMetodistDisciplines($metodistID) {
	   
		$listTeacher = self::find()->where(['intMetodistID'=> $metodistID])->all();
        
        $arr = array(); //массив объектов класса для объединения значений разных таблиц
        $i = 1;
        foreach ($listTeacher as $d):
            $TeacherDisciplin =Discipline::getTeacherDisciplin($d->intTeacherID);
            foreach ($TeacherDisciplin as $data):
            $arr[$i] = new Discipline();

            $arr[$i]->TeacherName = $data->TeacherName;
            $arr[$i]->TeacherSurname = $data->TeacherSurname;
            $arr[$i]->TeacherSecondName = $data->TeacherSecondName;
            $arr[$i]->EMail = $data->EMail;
            $arr[$i]->Chair = $data->Chair;
            $arr[$i]->ID = $data->ID;
            
            
            $arr[$i]->DisciplineID = $data->DisciplineID;
            $arr[$i]->TeacherID =$data->TeacherID;
            $arr[$i]->CourseID = $data->CourseID;
            $arr[$i]->Name = $data->Name;
            $arr[$i]->Info = $data->Info;
            $arr[$i]->Special =$data->Special;
            $i++;
            endforeach;
        endforeach;
        
		return $arr;
	}
	
    public static function getTeacherByUserID($id){
        $teacher = self::find()->where(['intID'=>$id])->one();
        return $teacher;
    }
}
