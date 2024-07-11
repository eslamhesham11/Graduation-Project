<?php
return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users', // يمكنك استخدام provider الخاص بالمستخدمين هنا
            'hash' => false,
        ],
        'api_admins' => [
            'driver' => 'jwt',
            'provider' => 'admins',
            'hash' => false,
        ],
        'api_students' => [
            'driver' => 'jwt',
            'provider' => 'students',
            'hash' => false,
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\admin::class, // قم بتعيين النموذج المناسب لجدول الطلاب
        ],
        'students' => [
            'driver' => 'eloquent',
            'model' => App\Models\student::class, // قم بتعيين النموذج المناسب لجدول الطلاب
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],


    /*
|--------------------------------------------------------------------------
| Password Confirmation Timeout
|--------------------------------------------------------------------------
|
| Here you may define the amount of seconds before a password confirmation
| times out and the user is prompted to re-enter their password via the
| confirmation screen. By default, the timeout lasts for three hours.
|
*/

    'password_timeout' => 10800,

];
