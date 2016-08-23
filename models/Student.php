<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tblStudents}}".
 *
 * @property integer $intStudentsID
 * @property string $charSurname
 * @property string $charName
 * @property string $charSecondName
 * @property string $charLogin
 * @property string $charPassword
 * @property string $charGroup
 */
class Student extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tblStudents}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['charSurname', 'charName', 'charSecondName', 'charLogin', 'charPassword', 'charGroup'], 'required'],
            [['charSurname', 'charName', 'charSecondName', 'charLogin', 'charPassword', 'charGroup'], 'string', 'max' => 256],
            [['charLogin'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intStudentsID' => 'Int Students ID',
            'charSurname' => 'Char Surname',
            'charName' => 'Char Name',
            'charSecondName' => 'Char Second Name',
            'charLogin' => 'Char Login',
            'charPassword' => 'Char Password',
            'charGroup' => 'Char Group',
        ];
    }
    public static function getStudent($id){
        $student = self::find()->where(['intStudentsID'=>$id])->one();
        return $student;
    }
    public static function getAll(){
        return self::findAll();
    }
    public static function getStudentByLogin($login){
        $student = self::find()->where(['charLogin'=>$login])->one();
        return $student;
    }
    
    public static function getStudentByUserID($id){
        $student = self::find()->where(['intID'=>$id])->one();
        return $student;
    }
    
}
