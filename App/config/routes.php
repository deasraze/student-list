<?php
return [
    '' => 'site/actionIndex',
    '\\?page=[1-9][0-9]*' => 'site/actionIndex',
    '\\?key=(id|name|surname|sgroup|score)&sort=(asc|desc)(&page=[1-9][0-9]*)?' => 'site/actionIndex',
    '\\?notification=(added|edited)&for=[0-9a-z]{64}' => 'site/actionIndex',
    '\\?notification=danger' => 'site/actionIndex',

    'form' => 'site/actionForm',

    'search\\?search=[\\w+%]+(&key=(id|name|surname|sgroup|score)&sort=(asc|desc))?(&page=[1-9][0-9]*)?' => 'site/actionSearch',
];
