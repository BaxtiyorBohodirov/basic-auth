<?php
namespace app\traits;
trait ResponseTrait {
    public function successJson($data, $message = 'Success', $status = 200) {
        return $this->formatResponse(true, $data, $message, $status);
    }

    public function errorJson($message = 'Error', $status = 400, $data = []) {
        return $this->formatResponse(false, $data, $message, $status);
    }

    public function formatResponse($success, $data, $message, $status) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        \Yii::$app->response->statusCode = $status;
        return [
            "success" => $success,
            "data" => $data,
            "message" => $message,
        ];
    }
}