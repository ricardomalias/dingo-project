<?php

return array(
    'customization' => array(
        'primary_color' => [
            'minlength' => "7",
            'maxlength' => "7",
            'default' => "#b9005f",
        ],
        'secondary_color' => [
            'minlength' => "7",
            'maxlength' => "7",
            'default' => "#006fbe",
        ]
    ),
    'finance' => array(
        'interest' => [
            'minlength' => "1",
            'maxlength' => "5",
            'default' => "0.033",
        ],
    ),
);
