<?php
return [
    '' => 'site/actionIndex',
    '\\?notification=(added|edited)&for=[0-9a-z]{64}' => 'site/actionIndex',
    'form' => 'site/actionForm',
    'search\\?search=[\\w+%]+' => 'site/actionSearch',
];
