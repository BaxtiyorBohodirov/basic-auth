<?php

namespace app\components;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    public static function generateToken($user_id) {
        $now = time();
        $payload = [
            'iat' => $now,
            'exp' => $now + 3600,
            'uid' => $user_id
        ];
        return JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
    }

    public static function validateToken($token) {
        try {
            return JWT::decode($token, new Key( $_ENV['JWT_SECRET'], 'HS256'));
        }
        catch (\Exception $e) {
            return false;
        }
    }
}