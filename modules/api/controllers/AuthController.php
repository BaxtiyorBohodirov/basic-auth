<?php

namespace app\modules\api\controllers;

use app\components\JwtHelper;
use app\models\User;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Request;

class AuthController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'login' => ['POST']
                ],
            ],
        ];
    }
    public function actionLogin() {

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = json_decode(\Yii::$app->request->getRawBody(), true);

        $username = $data['username'];

        $user = User::find()->where(['username' => $username])->one();

        $token = JWTHelper::generateToken($user->id);

        return $token;
    }
}