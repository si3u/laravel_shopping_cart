<?php
return [
    'to_read' => 'ДЕТАЛЬНІШЕ',
    'last_news' => 'ОСТАННІ НОВИНИ',
    'tags' => 'ТЕГИ',
    'quote_day' => 'ЦИТАТА ДНЯ!',
    'comment' => [
        'name' => 'Відгуки',
        'form' => [
            'header' => 'Остевте відгук',
            'name' => "Ваше ім'я",
            'email' => 'Ваш E-mail',
            'message' => 'Введіть відгук...',
            'submit' => 'Відправити'
        ],
        'validation' => [
            'news_id' => [
                'required' => 'Ви не передали ідентифікатор новини',
                'integer' => 'Ідентифікатор повинен бути цілочисленним значенням',
                'exists' => 'Новина с таким ідентифікатором не існує'
            ],
            'name' => [
                'required' => "Ви не ввели Им'я",
                'string' => "Ім'я повинно бути текстовим значенням",
                'max' => "Им'я не повинно перевищувати 255 символів"
            ],
            'email' => [
                'required' => 'Ви не вказали E-mail',
                'email' => 'E-mail не вірного формату',
                'max' => 'E-mail не повинен перевищувати 255 символів'
            ],
            'message' => [
                'required' => 'Ви не ввели коментарій',
                'string' => 'Коментарій повинен бути цілочисленним значенням',
                'max' => 'Коментарій не повинен перевищувати 1000 символів'
            ],
        ],
        'success' => "Коментарій успішно створений і відправлений на перевірку адміністрації сайту. Після перевірки коментарій з'явиться в списку коментаріїв."
    ],
];
