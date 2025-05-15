<?php

namespace app\controllers;

use app\traits\ResponseTrait;

class BaseApiController extends \yii\web\Controller
{
    use ResponseTrait;
    public $enableCsrfValidation = false;
}