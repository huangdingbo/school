<?php
namespace frontend\models;

use yii\base\Model;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $profile;
    public $nickname;
    public $id;
    public $pic;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\frontend\models\Adminuser', 'message' => '这个用户名已经被占用。'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\frontend\models\Adminuser', 'message' => '这个邮箱地址已经被占用了。'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入密码不一致'],

            ['nickname','required'],
            ['profile','string','max'=>128],

            [['pic'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'nickname' => '昵称',
            'password' => '密码',
            'password_repeat' => '再次输入密码',
            'email' => 'Email',
            'profile' => '简介',
            'pic' => '照片',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new Adminuser();
        $user->id = $this->id;
        $user->username = $this->username;
        $user->nickname = $this->nickname;
        $user->email = $this->email;
        $user->profile = $this->profile;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->password = '*';
        $user->password_reset_token = '';
        $user->pic = \Yii::$app->params['domain'].$this->pic;
//        $user->save();
//        var_dump($user->errors);exit;
        return $user->save() ? $user : null;
    }
}
