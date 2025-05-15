<?php

namespace app\components;

use app\models\User;
use app\traits\ResponseTrait;
use yii\base\ActionFilter;
use yii\helpers\VarDumper;
use yii\web\UnauthorizedHttpException;

class JwtAuth extends ActionFilter
{
    public function beforeAction($action) {
        $token = \Yii::$app->request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $token);
        if ($decoded = JwtHelper::validateToken($token)) {
            $user = User::findOne(($decoded->uid));
            if ($user) {
                \Yii::$app->user->setIdentity($user);
                return true;
            }
        }
        throw new UnauthorizedHttpException('Invalid token');
    }
}