<?php

namespace app\modules\api\forms;

use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public function rules() {
        return [
            [['username', 'password'], 'required']
        ];
    }
}