<?php
return [
    'to_read' => 'ПОДРОБНЕЕ',
    'last_news' => 'ПОСЛЕДНИЕ НОВОСТИ',
    'tags' => 'ТЕГИ',
    'quote_day' => 'ЦИТАТА ДНЯ!',
    'comment' => [
        'name' => 'Комментарии',
        'form' => [
            'header' => 'Оставить комментарий',
            'name' => 'Ваше имя',
            'email' => 'Ваш E-mail',
            'message' => 'Введите комментарий...',
            'submit' => 'Отправить'
        ],
        'validation' => [
            'news_id' => [
                'required' => 'Вы не передали идентификатор новости',
                'integer' => 'Идентификатор должен быть целочисленным значением',
                'exists' => 'Новость с таким идентификатором не существует'
            ],
            'name' => [
                'required' => 'Вы не ввели Имя',
                'string' => 'Имя должно быть текстовым значением',
                'max' => 'Имя не должно превышать 255 символов'
            ],
            'email' => [
                'required' => 'Вы не указали E-mail',
                'email' => 'E-mail не верного формата',
                'max' => 'E-mail не должен превышать 255 символов'
            ],
            'message' => [
                'required' => 'Вы не ввели комментарий',
                'string' => 'Комментарий должен быть целочисленным значением',
                'max' => 'Комментарий не должен превышать 1000 символов'
            ],
        ],
        'success' => 'Комментарий успешно создан и отправлен на проверку администрации сайта. После проверки он появится в списке комментариев'
    ]
];
