<?php

return [
    null => [\App\Operations\ExampleOperation::class],
    'page\/200\/?(?<id>\d+)?' => [\App\Operations\ExampleOperation::class, 'page200'],
    'page\/404\/?(?<id>\d+)?' => [\App\Operations\ExampleOperation::class, 'page404'],
];
