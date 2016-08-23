<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblPublish".
 *
 * @property integer $intNewsID
 * @property integer $intTeacherID
 * @property integer $intBossID
 */
class Publish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblPublish';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intNewsID'], 'required'],
            [['intNewsID', 'intTeacherID', 'intBossID'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intNewsID' => 'Int News ID',
            'intTeacherID' => 'Int Teacher ID',
            'intBossID' => 'Int Boss ID',
        ];
    }
    
    public static function getPublishByTeacherID($teacherid)
    {
    	$arr = array();
    	$list = self::find()->where(['intTeacherID' => $teacherid])->all();
    	$i = 1;
		foreach ($list as $one)
		{
			$arr[$i++] = $one->intNewsID; 
		} 
    	return $arr;
    }
    
    public static function getAuthor($id)
    {
    	$publish = self::find()->where(['intNewsID' => $id])->one();
    	if ($publish->intTeacherID != NULL || $publish->intTeacherID != 0){
    		$author = Teacher::find()->where(['intTeacherID' => $publish->intTeacherID])->one();
    	} 
    	else if ($publish->intBossID != NULL || $publish->intBossID != 0){
    		$author = Boss::find()->where(['intBossID' => $publish->intBossID])->one();
    	}    
    	return $author;
    }
    public static function create($publish)
	{
    	return $publish->save();
   	}
}
   