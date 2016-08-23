<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\News;

class NewsController extends Controller
{
    public function actionLast()
    {
        if (Yii::$app->user->isGuest)
        {
        	return Yii::$app->response->redirect(['site/login']);
        } 
        $news = News::getThree();
        return $this->render('listNews', ['news' => $news, 'mode' => false]);    
    }
    
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest)
        {
        	return Yii::$app->response->redirect(['site/login']);
        } 
        else if(Yii::$app->user->identity->status !== 1)
        {
        	if (Yii::$app->user->identity->status !== 3)
        	{
        		return $this->redirect(['news/last']);
        	}
        }
    	$new = new News();
    	
    	if ($_POST["News"])
    	{
    		$new->charText = $_POST["News"]['charText'];
    		$new->datDate = date('Y-m-d');
    		$author = [
				'alterID' => Yii::$app->user->identity->alterID,
				'status' => Yii::$app->user->identity->status
			];
    		if ($new->validate() && News::create($new, $author))
    		{
    			return $this->redirect(['last']);
    		}
			
    	}
    	
    	return $this->render('createNew', ['new' => $new]);
    }
    public function actionList()
    {
        if (Yii::$app->user->isGuest)
        {
        	return Yii::$app->response->redirect(['site/login']);
        } 
    	$news = News::getAll();
    	return $this->render('listNews', ['news' => $news, 'mode' => true]);
    }
    
}