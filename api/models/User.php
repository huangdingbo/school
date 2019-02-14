<?php
namespace api\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class User extends Model
{
    public $username;
    public $password;
    public $rememberMe = false;
    private $_user;

    //添加验证码验证类
//    public function scenarios() {
//        $scenarios = parent::scenarios();
//        $scenarios['login'] = ['username', 'password', 'rememberMe', 'verifyCode'];
//        return $scenarios;
//    }


    public function attributeLabels()
    {
        return [
            'username' => '姓名',
            'rememberMe' => '记住密码',
            'password' => '密码',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
//            ['verifyCode', 'captcha', 'on' => 'login'], //验证码
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}