<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tblNews".
 *
 * @property integer $intNewsID
 * @property string $charText
 * @property string $datDate
 */
class News extends \yii\db\ActiveRecord
{
	public $charName;
	public $charSurname;
	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tblNews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['charText', 'datDate'], 'required'],
            [['datDate'], 'safe'],
            [['charText'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'intNewsID' => 'Номер объявления',
            'charText' => 'Текст объявления',
            'datDate' => 'Дата создания',
        ];
    }
    public static function getThree()
    {
    	$news = self::find()->orderBy(['intNewsID' => SORT_DESC])->limit(3)->all();
    	//добавить авторов
    	foreach ($news as $new)
    	{
    		$author = Publish::getAuthor($new->intNewsID);
    		$new->charName = $author->charName;
    		$new->charSurname = $author->charSurname;
    	}
    	return $news;
    }
    public static function getAll()
    {
        $news = self::find()->orderBy(['datDate' => SORT_DESC])->all();
        foreach ($news as $new)
    	{
    		$author = Publish::getAuthor($new->intNewsID);
    		$new->charName = $author->charName;
    		$new->charSurname = $author->charSurname;
    	}
        //добавить авторов
        return $news;
    }
    public static function getNewsByTeacher($teacherID)
    {
		$teacherNewsIDs = Publish::getPublishByTeacherID($teacherID);
        $arr = array();
        $i = 1;
        foreach ($teacherNewsIDs as $nId => $value){
        	$new = self::find()->orderBy(['datDate' => SORT_DESC])->where(['intNewsID' => $value])->one();
        	$arr[$i++] = $new;
        }
		return $arr;
    }
    
    public static function create($new, $author)
    {
		$publish = new Publish();
		switch ($author['status'])
		{
			case 1:
			{
				$publish->intBossID = $author['alterID'];
				break;
			}
			case 2:
			{
				$new->addError('charText', 'Недостаточно прав для создания новой записи.');
				return false;
			}
			case 3:
			{
				$publish->intTeacherID = $author['alterID'];
				break;
			}
			case 4:
			{
				$new->addError('charText', 'Недостаточно прав для создания новой записи.');
				return false;
			}
		}
		if ($new->save())
		{
			$publish->intNewsID = $new->intNewsID;
			if ($publish->save())
			{
				return true;
			}
		}
		$new->delete();
		$new->addError('charText', 'Ошибка при создании новой записи. Попробуйте снова.');
		return false;
    }
}
