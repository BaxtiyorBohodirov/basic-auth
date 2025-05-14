<?php

namespace app\components;

use yii\base\ActionFilter;
use yii\helpers\VarDumper;

class JwtAuth extends ActionFilter
{
    public function beforeAction($action) {
        $token = \Yii::$app->request->headers->get('Authorization');
        $token = str_replace('Bearer ', '', $token);

        if ($decoded = JwtHelper::validateToken($token)) {
            VarDumper::dump($decoded, 10, true);
            \Yii::$app->user->setIdentity($decoded->uid);
        }
    }
}