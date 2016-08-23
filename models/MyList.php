<?php

namespace app\models;

class MyList extends \yii\db\ActiveRecord {
    
    public static function tableName()
    {
       return 'list'; 
    }
    
    public static function getAll()
    {
        $data = self::find()->All();
        return $data;   
    }
}