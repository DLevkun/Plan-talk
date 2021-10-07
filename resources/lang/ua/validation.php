<?php

return [
    'attributes' => [
        'comment' => 'коментар',
        'description' => 'опис',
        'full_name' => 'повне ім\'я',
        'nickname' => 'нікнейм',
        'email' => 'електронна почта',
        'title' => 'заголовок',
        'search_field' => 'запит'
    ],
    'max' => [
        'numeric' =>  'Поле :attribute має бути не більше :max.',
        'file' => 'Поле :attribute має мати розмір не більше :max кілобайтів.',
        'string' => 'Поле :attribute має бути не більше :max символів.',
        'array' => 'Поле :attribute має мати не більше :max елементів.',
    ],
    'required' => 'Поле :attribute не може бути пустим.',
    'string' => 'Поле :attribute має бути строкою.',
    'email' => 'Неправильний формат введення електронної адреси.',
];

