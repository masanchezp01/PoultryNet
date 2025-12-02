<?php

declare(strict_types=1);

return [
    'credentials' => [
        'file' => base_path(env('FIREBASE_CREDENTIALS')),
    ],

    'project_id' => env('FIREBASE_PROJECT_ID', 'poultry-42391'),

    'database' => [
        'url' => env('FIREBASE_DATABASE_URL', 'https://poultry-42391.firebaseio.com'),
    ],
];
