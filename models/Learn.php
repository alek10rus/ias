<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblLearn".
 *
 * @property integer $intStudentsID
 * @property integer $intCourseID
 */
class Learn extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblLearn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intStudentsID', 'intCourseID'], 'required'],
            [['intStudentsID', 'intCourseID'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intStudentsID' => 'ID студента',
            'intCourseID' => 'ID курса',
        ];
    }
    public static function getCourseID($studentID){
        $learn = self::find()->where(['intStudentsID' => $studentID])->one();
        return $learn->intCourseID;
    }
}
