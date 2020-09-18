<?php

return [
    'user.users' => [
        'index' => 'user::users.list user',
        'create' => 'user::users.create user',
        'edit' => 'user::users.edit user',
        'destroy' => 'user::users.destroy user',
    ],
    'user.custom-user' => [
        'index' => 'user::custom-user.list user',
        'create' => 'user::custom-user.create user',
        'edit' => 'user::custom-user.edit user',
        'destroy' => 'user::custom-user.destroy user',
    ],
    'user.roles' => [
        'index' => 'user::roles.list resource',
        'create' => 'user::roles.create resource',
        'edit' => 'user::roles.edit resource',
        'destroy' => 'user::roles.destroy resource',
    ],
    'account.api-keys' => [
        'index' => 'user::users.list api key',
        'create' => 'user::users.create api key',
        'destroy' => 'user::users.destroy api key',
    ],
];
