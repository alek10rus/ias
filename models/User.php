<?php

namespace app\models;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $id;
    public $login;
    public $password;
    public $status;
    public $name;
    public $surname;
    public $alterID;
    public $course;

    public static function tableName()
    {
        return '{{%tblUser}}';
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $user = self::find($id)->where(['intId'=>$id])->one();
        $userinfo = null;
        $data = new User();
        $alId = null;
        $cours = null;
        switch($user->intStatus){
            case 1: {
                $userinfo = Boss::getBossByUserID($id); 
                $alId = $userinfo->intBossID;
                break;
            };
            case 2: {
                $userinfo = Metodist::getMetodistByUserID($id); 
                $alId = $userinfo->intMetodistID;
                break;
            };
            case 3: {
                $userinfo = Teacher::getTeacherByUserID($id); 
                $alId = $userinfo->intTeacherID;
                break;   
            };
            case 4: {
                $userinfo = Student::getStudentByUserID($id);
                $cours = Course::getCourse(Learn::getCourseID($userinfo->intStudentsID));
                $alId = $userinfo->intStudentsID;
            };
        }
        
        $data=[
            'id' => $user->intID,
            'login' => $user->charLogin,
            'password' => $user->charPassword,
            'status' => $user->intStatus,
            'name' => $userinfo->charName,
            'surname' => $userinfo->charSurname,
            'alterID' => $alId,
            'course' => $cours,                                   
        ];
                                        
        return new static($data);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by login
     *
     * @param string $login
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $user = self::find()->where(['charLogin'=>$username])->one();
        $id = $user->intID;
        $userinfo = null;
        $data = new User();
        $alId = null;
        $cours = null;
        switch($user->intStatus){
            case 1: {
                $userinfo = Boss::getBossByUserID($id); 
                $alId = $userinfo->intBossID;
                break;
            };
            case 2: {
                $userinfo = Metodist::getMetodistByUserID($id); 
                $alId = $userinfo->intMetodistID;
                break;
            };
            case 3: {
                $userinfo = Teacher::getTeacherByUserID($id); 
                $alId = $userinfo->intTeacherID;
                break;   
            };
            case 4: {
                $userinfo = Student::getStudentByUserID($id);
                $cours = Course::getCourse(Learn::getCourseID($userinfo->intStudentsID));
                $alId = $userinfo->intStudentsID;
            };
        }
        
        $data=[
            'id' => $user->intID,
            'login' => $user->charLogin,
            'password' => $user->charPassword,
            'status' => $user->intStatus,
            'name' => $userinfo->charName,
            'surname' => $userinfo->charSurname,
            'alterID' => $alId,
            'course' => $cours
                                  
        ];            
            
        return new static($data);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
