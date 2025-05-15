<?php

namespace app\modules\api\controllers;

use app\components\JwtHelper;
use app\controllers\BaseApiController;
use app\models\User;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Request;

class AuthController extends BaseApiController
{
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => ['POST']
                ],
            ],
            'checkAuth' => [
                'class' => \app\components\JwtAuth::class,
                'except' => ['login']
            ]
        ];
    }
    public function actionLogin() {

        $data = json_decode(\Yii::$app->request->getRawBody(), true);

        $login_form = new \app\modules\api\forms\LoginForm();

        $login_form->load([
            'LoginForm' => $data
        ]);

        if (!$login_form->validate()) {
            return  $this->errorJson( "Validation error", 422, $login_form->getErrors());
        }

        $username = $data['username'];
        $password = $data['password'];

        $ip = \Yii::$app->request->userIP;
        $key = $ip."-".$username;
        $count = \Yii::$app->cache->get($key);

        if ($count > 2) {
            return $this->errorJson("Ko'plab muvaffaqiyatsiz urunishlar sabab 3 daqiqaga bloklandingiz!", 401);
        }

        $user = User::findByUsername($username);

        if ($user && \Yii::$app->security->validatePassword($password, $user->password_hash)) {
            $token = JWTHelper::generateToken($user->id);
            \Yii::$app->cache->delete($key);
            return $this->successJson([
                "token" => $token
            ]);
        }

        $count = $count ? $count + 1 : 1;
        \Yii::$app->cache->set($key, $count, 180);

        return $this->errorJson("Invalid username or password", 401);
    }

    public function actionMe() {
        return $this->successJson(\Yii::$app->user->identity);
    }
}