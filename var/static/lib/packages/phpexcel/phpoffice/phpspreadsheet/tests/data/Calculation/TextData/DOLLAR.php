<?php

return [
    [
        '$123.46',
        123.456,
        2,
    ],
    [
        '$123.32',
        123.321,
        2,
    ],
    [
        '$1,235,000',
        1234567,
        -3,
    ],
    [
        '$1,200,000',
        1234567,
        -5,
    ],
    [
        '#NUM!',
        'ABC',
        2,
    ],
    [
        '#NUM!',
        123.456,
        'ABC',
    ],
];
