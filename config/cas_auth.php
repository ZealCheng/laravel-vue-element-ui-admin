<?php
return [
	// Cas Default Api
	'uri'      => env('CAS_URI', 'https://cas.360gst.com'),
	'login'    => env('CAS_LOGIN', '/login'),
	'logout'   => env('CAS_LOGOUT', '/logout'),
	'validate' => env('CAS_VALIDATE', '/api/validate'),
	'auth'     => env('CAS_AUTH', '/api/auth'),
	// App Configuration
	'host'         => env('CAS_HOST'),
	'secret'       => env('CAS_SECRET'),
	'callback_uri' => env('CAS_CALLBACK_URI', '/cas-auth/callback'),
	'default_uri'  => env('CAS_DEFAULT_URI', '/'),
	'app_type'     => env('CAS_APP_TYPE', '2'), // 1 => Cgi 2 => La
    // User Model Mapping
    'mapping' => [
        'id'          => 'id',
        'realname'    => 'name',
        'employee_id' => 'employee_id',
        'email'       => 'email',
        'mobile'      => 'mobile',
        'permissions' => 'permissions',
    ],
];