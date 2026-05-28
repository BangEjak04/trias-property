<?php

return [
    'model' => [
        'label' => 'User',
        'pluralLabel' => 'Users',
    ],
    'field' => [
        'name' => 'Name',
        'username' => 'Username',
        'email' => 'Email',
        'role' => 'Role',
        'password' => 'Password',
        'password_change' => 'Change password',
        'password_confirmation' => 'Password confirmation',
    ],
    'section' => [
        'information' => [
            'label' => 'Detail Information',
            'description' => 'Update your account profile information and email address.',
        ],
        'password' => [
            'label' => 'Update Password',
            'description' => 'Ensure your account is using long, random password to stay secure.',
        ],
    ],
];
