<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Members Model Configs
    |--------------------------------------------------------------------------
    |
    */

    'marital_status' => [
        'options' =>    [
            'single',
            'engaged',
            'married',
            'divorced',
            'widowed',
            'separated',
            'unknown',
            'deceased'
        ],
        'default' => 'unknown'
    ],
    
    'preferred_language' => [
        'options' =>    [
            'english', 
            'russian'
        ],
        'default' => 'english'
    ],
    
    'preferred_contact' =>  [
        'options' => [
            'sms', 
            'email'
        ],
        'default' => 'sms'
    ],
    
    'nationality' => [
        'options' => [
            'american', 
            'russian', 
            'ukrainian', 
            'moldovian', 
            'belorussian', 
            'unknown'
        ],
        'default' => 'unknown'
    ],
    
    'department' => [
        'options' => [
            'college', 
            'youth', 
            'unknown'
        ],
        'default' => 'unknown'
    ],
    
    'gender' => [
        'options' => [
            'male',
            'female',
            'unknown'
        ],
        'default' => 'unknown'
    ],
    
    'status' => [
        'options' => [
            'attender', 
            'visitor', 
            'member', 
            'inactive', 
            'unknown'
        ],
        'default' => 'unknown'
    ],
    
    'education' => [
        'options' => [
            'unknown', 
            'diploma', 
            'associate', 
            'bachelor', 
            'masters', 
            'professional', 
            'doctoral'
        ],
        'default' => 'unknown'
    ]
];
