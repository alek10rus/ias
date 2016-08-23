<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblCourse".
 *
 * @property integer $intCourseID
 * @property integer $intNCourse
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblCourse';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intNCourse'], 'required'],
            [['intNCourse'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intCourseID' => 'ID курса',
            'intNCourse' => 'Номер курса',
        ];
    }
    public static function getCourse($courseID){
        $course = self::find()->where(['intCourseID' => $courseID])->one();
        return $course->intNCourse;
    }
}
