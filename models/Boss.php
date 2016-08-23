<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblBoss".
 *
 * @property integer $intBossID
 * @property string $charSurname
 * @property string $charName
 * @property string $charSecondName
 */
class Boss extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblBoss';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['charSurname', 'charName', 'charSecondName'], 'required'],
            [['charSurname', 'charName', 'charSecondName'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intBossID' => 'Int Boss ID',
            'charSurname' => 'Char Surname',
            'charName' => 'Char Name',
            'charSecondName' => 'Char Second Name',
        ];
    }
    
    public static function getBoss($id)
	{
		$boss = self::find()->where(['intBossID'=>$id])->one();
		return $boss;
	}
		
	public static function getBossByUserID($id)
	{
		$boss = self::find()->where(['intID'=>$id])->one();
        return $boss;
	}
}
