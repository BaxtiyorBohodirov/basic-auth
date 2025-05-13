<?php

namespace app\modules\api\controllers;

use yii\filters\VerbFilter;
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
        return $data;
    }
}