<?php
namespace api\models;

use common\models\User;
use Yii;
use yii\base\Model;
use yii\db\Query;

/**
 * Login form
 */
class Login extends Model
{
    public $username;
    public $password;

    public function rules()
    {
        return [
            [['username','password'],'safe']
        ];
    }

    public function check(){
        $user = (new Query())->from('user_web')->where(['username'=>$this->username,'password'=>$this->password])->one();
        if (!$user){
            return false;
        }
        return true;
    }

    public function getUser(){
        $user = (new Query())->from('user_web')->where(['username'=>$this->username,'password'=>$this->password])->one();
        return $user['username'];
    }
}
