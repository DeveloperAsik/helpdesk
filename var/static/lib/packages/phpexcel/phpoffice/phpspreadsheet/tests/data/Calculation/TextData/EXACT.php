<?php

return [
    [
        true,
        '',
        '',
    ],
    [
        true,
        '1000',
        1000,
    ],
    [
        true,
        1000,
        '1000',
    ],
    [
        true,
        'Abč',
        'Abč',
    ],
    [
        false,
        'abč',
        'Abč',
    ],
    [
        false,
        '10.010',
        10.01,
    ],
    [
        false,
        '  ',
        '',
    ],
];
