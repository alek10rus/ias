<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tblMetodist}}".
 *
 * @property integer $intMetodistID
 * @property string $charSurname
 * @property string $charName
 * @property string $charSecondName
 * @property string $charLogin
 * @property string $charPassword
 */
class Metodist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tblMetodist}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['charSurname', 'charName', 'charSecondName'], 'required'],
            [['charSurname', 'charName', 'charSecondName'], 'string', 'max' => 256],
            [['charLogin'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intMetodistID' => 'ID Методиста',
            'charSurname' => 'Фамилия',
            'charName' => 'Имя',
            'charSecondName' => 'Отчество',
            'intID'=>'Номер в tblUser'
        ];
    }
    public static function getMetodist($id){
        $metodist = self::find()->where(['intMetodistID'=>$id])->one();
        return $metodist;
    }
    public static function getMetodistByUserID($userId){
        $metodist = self::find()->where(['intID'=>$userId])->one();
        return $metodist;
    }
}
