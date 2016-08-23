<?php

namespace app\models;
use Yii;
/**
 * This is the model class for table "{{%tblTeacher}}".
 *
 * @property integer $intDisciplineID
 * @property string $intTeacherID;
 * @property string $intCourseID;
 * @property string $charName;
 * @property string $charInfo;
 * @property string $charSpecial;
 */
class Discipline extends \yii\db\ActiveRecord
{
    
    public $DisciplineID;
    public $TeacherID;
    public $CourseID;
    public $Name;
    public $Info;
    public $Special;

    public $TeacherName;
    public $TeacherSurname;
    public $TeacherSecondName;
    public $EMail;
    public $Chair;
    public $ID;

    public $contain;
    /*
    *Задается название таблицы “tblDiscipline” БД для обращения к этой таблице
    *ходные параметры: нет
    *Возвращаемые параметры: $name - название таблицы
    */
    public static function tableName()
    {
        return 'tblDiscipline';
    }

    public function rules()
    {
        return [[['charName',], 'required'], 
        [['charName'],'string', 'max' => 256], ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ['intDisciplineID' => 'Int Discipline ID', 'intTeacherID' =>
            'Int Teacher ID', 'intCourseID' => 'Int Course ID', 'charName' => 'Char Name',
            'charInfo' => 'Char Info', 'charSpecial' => 'Char Special'];
    }
    /*
    *возвращает объект таблицы tblDiscipline по номеру id
    *Входные параметры: $id - номер дисциплины в таблице tblDiscipline1
    *Возвращаемые параметры: $discipline - объект класса Discipline(ассоциативный массив, 1
    *в котором названиями ключей являются названия полей tblDiscipline, а также необходимо извлечь из модели Teacher0
    *по номеру преподавателя из $discipline, данные об этом преподавателе, и добавить эти данные в массив): 0
    
    *$discipline - ассоциативный массив, с ключами: 
    *intDisciplineID, charName,charInfo, charSpecial, intCourseID, intTeacherID, charTeacherName,charTeacherSurname, charTeacherSecondName, 
    *charEMail, charChair
    */
    public static function getDiscipline($id) //сделано согласно описанию
    {
        $disciplineData = self::find()->where(['intDisciplineID' => $id])->one();
        return $disciplineData;
    }

    /*
    *возвращает массив объектов таблицы tblDiscipline по номеру преподавателя $teacherId
    *Входные параметры: $teacherId - номер преподавателя, по которому надо сделать выборку
    *Возвращаемые параметры: $disciplines - массив объектов таблицы tblDiscipline
    */
    public static function getTeacherDisciplin($id)
    {
        $disciplineData = self::find()->where( ['intTeacherID'=>$id])->all();
        //дальше часть для объединениея информации из 2-х таблиц (возможно есть вариант по красивее и проще)
        $arr = array(); //массив объектов класса для объединения значений разных таблиц
        $i = 1;
        foreach ($disciplineData as $d):
            $i++;
            $arr[$i] = new Discipline();
            $arr[$i]->DisciplineID = $d->intDisciplineID;
            $arr[$i]->TeacherID = $d->intTeacherID;
            $arr[$i]->CourseID = $d->intCourseID;
            $arr[$i]->Name = $d->charName;
            $arr[$i]->Info = $d->charInfo;
            $arr[$i]->Special = $d->charSpecial;

            $teacher = Teacher::getTeacher($d->intTeacherID);

            $arr[$i]->TeacherName = $teacher->charName;
            $arr[$i]->TeacherSurname = $teacher->charSurname;
            $arr[$i]->TeacherSecondName = $teacher->charSecondName;
            $arr[$i]->EMail = $teacher->charEMail;
            $arr[$i]->Chair = $teacher->charChair;
            $arr[$i]->ID = $teacher->intID;
            $arr[$i]->contain = false;
            /*
            дальше нужен contain модель) 
            */
            
        endforeach;
        return $arr;


    }
    /*
    *возвращает массив объектов таблицы tblDiscipline по номеру курса $courseId, 
    *также необходимо добавить информацию о преподавателе в массив, так же для каждой записи необходимо добавить поле $contain, 
    *которое == true если для данной пары $studentID, intDisciplineID существует запись в tblContain
    *и == false если данной записи в tblContain нет.
    *Входные параметры: $courseId - номер курса, по которому надо сделать выборку
    *$studentID - id студента в tblStudent
    *Возвращаемые параметры: $listDisciplines - массив с целочисленными ключами, по значению которых, равным intDisciplineID, 
    *хранятся ассоциативные массивы с полями: intDisciplineID, intTeacherID, intCourseID, charName, charTeacherName, 
    *charTeacherSurname, charEMail, charChair
    */
    public static function getCourseDisciplines($courseId, $studentID)
    {
        /*Доделать*/
        $disciplineData = self::find()->where(['intCourseID' => $courseId])->all();

        $arr = array(); //массив объектов класса для объединения значений разных таблиц
        $i = 1;
        foreach ($disciplineData as $d):
            $i++;
            $arr[$i] = new Discipline();
            $arr[$i]->DisciplineID = $d->intDisciplineID;
            $arr[$i]->TeacherID = $d->intTeacherID;
            $arr[$i]->CourseID = $d->intCourseID;
            $arr[$i]->Name = $d->charName;
            $arr[$i]->Info = $d->charInfo;
            $arr[$i]->Special = $d->charSpecial;

            $teacher = Teacher::getTeacher($d->intTeacherID);

            $arr[$i]->TeacherName = $teacher->charName;
            $arr[$i]->TeacherSurname = $teacher->charSurname;
            $arr[$i]->TeacherSecondName = $teacher->charSecondName;
            $arr[$i]->EMail = $teacher->charEMail;
            $arr[$i]->Chair = $teacher->charChair;
            $arr[$i]->ID = $teacher->intID;
            $arr[$i]->contain = Contain::сheckStudent($studentID, $d->intDisciplineID);

        endforeach;
        return $arr;
    }

    public static function getListDisciplines()
    {
        $disciplineData = self::find()->all();


        $arr = array();
        $i = 1;
        foreach ($disciplineData as $d):
            $i++;
            $arr[$i] = new Discipline();
            $arr[$i]->DisciplineID = $d->intDisciplineID;
            $arr[$i]->TeacherID = $d->intTeacherID;
            $arr[$i]->CourseID = $d->intCourseID;
            $arr[$i]->Name = $d->charName;
            $arr[$i]->Info = $d->charInfo;
            $arr[$i]->Special = $d->charSpecial;

            $teacher = Teacher::getTeacher($d->intTeacherID);

            $arr[$i]->TeacherName = $teacher->charName;
            $arr[$i]->TeacherSurname = $teacher->charSurname;
            $arr[$i]->TeacherSecondName = $teacher->charSecondName;
            $arr[$i]->EMail = $teacher->charEMail;
            $arr[$i]->Chair = $teacher->charChair;
            $arr[$i]->ID = $teacher->intID;
        endforeach;
        return $arr;

    }
}
