<?php
return [
    'sync' => [
        'type' => 2,
    ],
    'manage' => [
        'type' => 2,
    ],
    'index' => [
        'type' => 2,
    ],
    'create' => [
        'type' => 2,
    ],
    'view' => [
        'type' => 2,
    ],
    'update' => [
        'type' => 2,
    ],
    'delete' => [
        'type' => 2,
    ],
    'manageOrders' => [
        'type' => 2,
    ],
    'guest' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'view',
        ],
    ],
    'manager' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'index',
            'create',
            'update',
            'manage',
            'guest',
        ],
    ],
    'api' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'sync',
            'guest',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'delete',
            'manageOrders',
            'manager',
        ],
    ],
];
