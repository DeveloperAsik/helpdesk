<?php

return [
    [
        '19-12-1960 01:30:00',
        22269.0625,
        'dd-mm-yyyy hh:mm:ss',
    ],
    // Oasis uses upper-case
    [
        '12/19/1960 01:30:00',
        22269.0625,
        'MM/DD/YYYY HH:MM:SS',
    ],
    // Date with plaintext escaped with a \
    [
        '1960-12-19T01:30:00',
        22269.0625,
        'yyyy-mm-dd\\Thh:mm:ss',
    ],
    // Date with plaintext in quotes
    [
        '1960-12-19T01:30:00 Z',
        22269.0625,
        'yyyy-mm-dd"T"hh:mm:ss \\Z',
    ],
    // Date with quoted formatting characters
    [
        'y-m-d 1960-12-19 h:m:s 01:30:00',
        22269.0625,
        '"y-m-d" yyyy-mm-dd "h:m:s" hh:mm:ss',
    ],
    // Date with quoted formatting characters
    [
        'y-m-d 1960-12-19 h:m:s 01:30:00',
        22269.0625,
        '"y-m-d "yyyy-mm-dd" h:m:s "hh:mm:ss',
    ],
    // Chinese date format
    [
        '1960年12月19日',
        22269.0625,
        '[DBNum1][$-804]yyyy"年"m"月"d"日";@',
    ],
    [
        '1960年12月',
        22269.0625,
        '[DBNum1][$-804]yyyy"年"m"月";@',
    ],
    [
        '12月19日',
        22269.0625,
        '[DBNum1][$-804]m"月"d"日";@',
    ],
    [
        '07:35:00 AM',
        43270.315972222,
        'hh:mm:ss\ AM/PM',
    ],
    [
        '02:29:00 PM',
        43270.603472222,
        'hh:mm:ss\ AM/PM',
    ],
    [
        '8/20/2018',
        43332,
        '[$-409]m/d/yyyy',
    ],
    [
        '8/20/2018',
        43332,
        '[$-1010409]m/d/yyyy',
    ],
    [
        '27:15',
        1.1354166666667,
        '[h]:mm',
    ],
    // Percentage
    [
        '12%',
        0.12,
        '0%',
    ],
    // Simple color
    [
        '12345',
        12345,
        '[Green]General',
    ],
    // Multiple colors
    [
        '12345',
        12345,
        '[Blue]0;[Red]0',
    ],
];
