<?php

namespace app\components;

use app\models\User;
use app\traits\ResponseTrait;
use yii\base\ActionFilter;
use yii\helpers\VarDumper;
use yii\web\UnauthorizedHttpException;

class CheckUserBanned extends ActionFilter
{
    public function beforeAction($action) {
        
    }
}