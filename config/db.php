<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=PostgreSQL-16;dbname=basic_auth_db',
    'username' => 'postgres',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
