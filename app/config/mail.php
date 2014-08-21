<?php

return array(

    'feedback' => array(
        'address' => 'support@grapheme.ru',
        #'subject' => 'ВидеоГид, обратная связь',
    ),

    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'from' => array(
        'address' => 'guidetohei@gmail.com',
        'name' => 'ВидеоГид'
    ),
    'username' => 'guidetohei@gmail.com',
    'password' => 'PeL5hvBd',

    'sendmail' => '/usr/sbin/sendmail -bs',
    'encryption' => 'tls',

    'pretend' => false,
);