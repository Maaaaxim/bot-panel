<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Calories365 bot lang
    |--------------------------------------------------------------------------
    |
    |
    */

    'auth_required' => 'Ви повинні бути авторизовані!',
    'error_retrieving_data' => 'Сталася помилка під час отримання даних. Будь ласка, спробуйте пізніше.',
    'no_entries_for_date' => 'У вас немає записів за дату *:date*.',
    'no_entries_for_part_of_day' => 'У вас немає записів :partOfDayText.',
    'your_data_for_date' => 'Ваші дані за *:date*:',
    'breakfast' => 'Сніданок',
    'lunch' => 'Обід',
    'dinner' => 'Вечеря',
    'calories' => 'Калорії',
    'proteins' => 'Білки',
    'fats' => 'Жири',
    'carbohydrates' => 'Вуглеводи',
    'total_for_day' => 'Всього за день',
    'total_for_part_of_day' => 'Всього за :partOfDayName',
    'delete' => 'Видалити',
    'you_said'  => 'Ви сказали: ',
    'parameter' => 'Параметр',
    '100g'      => '100г',
    'g'         => 'г',
    'editing_session_expired' => 'Сесія редагування завершена або відсутня.',
    'product_not_found'       => 'Продукт не знайдено або час сеансу вичерпано.',
    'editing_canceled' => 'Редагування скасовано.',
    'step_skipped'                        => 'Крок пропущено.',
    'please_enter_new_quantity_of_grams'  => 'Будь ласка, введіть нову кількість грамів.',
    'please_enter_new_calories'           => 'Будь ласка, введіть нову кількість калорій.',
    'please_enter_new_proteins'           => 'Будь ласка, введіть нову кількість білків.',
    'please_enter_new_fats'               => 'Будь ласка, введіть нову кількість жирів.',
    'please_enter_new_carbohydrates'      => 'Будь ласка, введіть нову кількість вуглеводів.',
    'error_editing_product'               => 'Сталася помилка під час редагування продукту.',
    'exit_edit_mode' => 'Вийдіть з режиму редагування (натисніть зберегти або скасувати).',
    'action_canceled_product_list_cleared' => 'Дію скасовано. Ваш список продуктів було очищено.',
    'cancellation_completed'               => 'Скасування виконано',
    'product_list_is_empty_or_was_cleared' => 'Ваш список продуктів порожній або вже був очищений.',
    'list_is_already_empty'                => 'Список вже порожній',
    'product_removed_from_list' => 'Продукт видалено зі списку.',
    'error_deleting_product' => 'Ошибка при удалении продукта.',
    'product_deleted' => 'Продукт удалён.',
    'you_are_editing_product'        => 'Ви редагуєте продукт: *:productName*',
    'please_enter_new_product_name'  => 'Будь ласка, введіть нову назву продукту.',
    'save'                           => 'Зберегти',
    'skip_step'                      => 'Пропустити крок',
    'cancel'                         => 'Скасувати',
    'invalid_request'                => 'Некоректний запит.',
    'data_saved_you_consumed' => 'Дані збережено, Ви вжили',
    'grams'                     => 'грамів',
    'error_processing_data'     => 'Сталася помилка під час обробки даних.',
    'error_generating_data'     => 'Сталася помилка під час генерації даних.',
    'failed_to_get_product_data'=> 'Не вдалося отримати дані продукту.',
    'product_data_updated'      => 'Дані продукту оновлено.',
    'value_too_long'                           => 'Значення занадто довге',
    'enter_valid_numeric_value_for_grams'      => 'Будь ласка, введіть коректне числове значення для грамів.',
    'enter_valid_numeric_value_for_calories'   => 'Будь ласка, введіть коректне числове значення для калорій.',
    'enter_valid_numeric_value_for_proteins'   => 'Будь ласка, введіть коректне числове значення для білків.',
    'enter_valid_numeric_value_for_fats'       => 'Будь ласка, введіть коректне числове значення для жирів.',
    'enter_valid_numeric_value_for_carbohydrates' => 'Будь ласка, введіть коректне числове значення для вуглеводів.',
    'please_choose_your_language' => 'Будь ласка, оберіть мову',
    'language_set_english'        => 'Вашу мову встановлено на англійську.',
    'language_set_russian'        => 'Вашу мову встановлено на російську.',
    'language_set_ukrainian'      => 'Вашу мову встановлено на українську.',
    'invalid_or_used_code' => 'Код недійсний або вже використаний. Будь ласка, зареєструйтеся знову.',
    'seems_you_are_new'    => 'Схоже, ви тут уперше. Щоб зв’язати обліковий запис, використайте посилання «Підключити» з особистого кабінету (https://calculator.calories365.com).',
    'error_occurred' => 'Сталася помилка: ',
    'incomplete_product_info' => 'Неповна інформація про продукт.',
    'save_products_for' => 'Зберегти продукти на:',
    'products_not_found' => 'Продукти не знайдено.',
    'failed_to_recognize_audio_message' => 'Не вдалося розпізнати аудіоповідомлення.',
    'not_an_audio_message_received' => 'Отримано не аудіоповідомлення.',
    'changes_saved' => 'Зміни збережено.',
    'changes_canceled' => 'Зміни скасовано.',
    'message_not_modified' => 'Повідомлення не змінилося, оновлення не потрібне.',
    'search' => 'Шукати',
    'edit' => 'Змінити',
    'you_must_be_authorized' => 'Ви маєте бути авторизованими!',
    'prompt_analyze_food_intake' => <<<EOT
Аналізуй текст: ":text". Виведи лише список продуктів із вказаною кількістю в грамах. Якщо кількість не вказана, використовуй середньостатистичну вагу чи порцію. Формат виводу повинен точно відповідати наведеному прикладу, де після кожного продукту стоїть крапка з комою:

Приклад:
Картопля - 100 грамів;
Помідор - 120 грамів;
Курка221 - 200 грамів;

Якщо в тексті немає продуктів, виведи: 'продуктів немає'.

Важливо:
- Усі кількості мають бути в грамах.
- Після кожного продукту обов'язково став крапку з комою.
- Не додавай жодної додаткової інформації, крім списку продуктів.
- Продукт може містити літери та цифри (наприклад, курка221 або курка два два один). Зберігай повні назви продуктів без змін.
- Якщо продукт має описові слова (наприклад, варена картопля), перестав опис після назви продукту (наприклад, 'варена картопля' → 'картопля варена').
- Переконайся, що кожен продукт і його кількість розділені тире та пробілами, як у прикладі.
- Не змінюй вихідну назву продукту, навіть якщо вона містить цифри чи нестандартні символи.

Приклади вхідного тексту та очікуваного виводу:

1. Вхідний текст: 'Я з’їв 100 грамів картоплі і помідор.'
   Очікуваний вивід:
   Картопля - 100 грамів;
   Помідор - 120 грамів;

2. Вхідний текст: 'Я з’їв 100 грамів картоплі, помідор і курка221.'
   Очікуваний вивід:
   Картопля - 100 грамів;
   Помідор - 120 грамів;
   Курка221 - 200 грамів;

3. Вхідний текст: 'Я з’їв 100 грамів картоплі, помідор і курка два два один.'
   Очікуваний вивід:
   Картопля - 100 грамів;
   Помідор - 120 грамів;
   Курка два два один - 200 грамів;

4. Вхідний текст: 'Я з’їв варений картопель'
   Очікуваний вивід:
   Картопель варений - 200 грамів;

5. Вхідний текст: 'Сьогодні нічого не їв.'
   Очікуваний вивід:
   продуктів немає

6. Вхідний текст: 'Я з'їв два яйця'
   Очікуваний висновок:
   Яйце - 120 грамів;
EOT,

    'prompt_generate_new_product_data' => <<<EOT
Є продукт: ":text". Виведи КБЖУ (Калорії, Білки, Жири, Вуглеводи) на 100 грамів продукту.
Формат виводу має точно відповідати прикладу, де після кожного параметру стоїть крапка з комою:

Приклад: Калорії - 890; Білки - 0.2; Жири - 100; Вуглеводи - 0;

Важливо:

- Усі значення повинні відповідати 100 грамам продукту.
- Після кожного параметра обов’язково став крапку з комою.
- Не додавай жодної додаткової інформації, окрім списку КБЖУ.
- Назву продукту зберігай без змін, навіть якщо вона містить цифри чи нестандартні символи.
- Переконайся, що кожен параметр і його значення розділені тире та пробілами, як у прикладі.
- Також врахуй, що користувач може називати продукти як загальновідомі, так і брендові (наприклад, 'Halls' або 'Цукерка Bob and Snail'). Таке теж треба розпізнавати і повертати інформацію.

Приклад вхідного тексту:
Калорії - 890; Білки - 0.2; Жири - 100; Вуглеводи - 0;
EOT,

    'prompt_choose_relevant_products_part' => <<<EOT
Який продукт найбільше відповідає назві ":name"? Ось доступні варіанти: :productNames.
EOT,

    'prompt_choose_relevant_products_footer' => <<<EOT
Поверни відповідь у такому форматі:
назва продукту1 - id;
назва продукту2 - id;
якщо підходящого продукту немає, то відповідь має бути у форматі
назва продукту - (його калорійність на 100грамів, білки, жири, вуглеводи);
EOT,

    'data_not_extracted' => 'Не вдалося отримати дані.',
    'welcome_guide' => <<<EOT
Ласкаво просимо до боту «Калорій 365»! Ось як ним користуватися:

1) Голосове введення:
Надішліть голосове повідомлення з тим, що ви з’їли за прийом їжі. Бот розпізнає продукти й сформує список.

2) Редагування списку:
Натисніть кнопку «Змінити», щоб вручну виправити назву, калорії, білки, жири або вуглеводи.
Натисніть кнопку «Шукати», щоб знайти новий профіль КБЖУ для продукту. Якщо результат пошуку вас не задовольнив після першого натискання, натисніть ще раз!

3) Збереження:
Натисніть кнопку «Зберегти», щоб зберегти дані у ваш щоденник.

4) Статистика за день:
Введіть команду /stats, щоб побачити статистику за день.

Почніть вести свій щоденник калорій легко й зручно!
EOT,
    'menu'             => 'Меню',
    'statistics'       => 'Статистика',
    'choose_language'  => 'Вибір мови',
    'feedback'         => 'Зворотний зв\'язок',
    'whole_day' => 'Весь день',
    'send_feedback_email' => 'Ви можете надіслати свій відгук на пошту: mostlysunny1488@gmail.com',
];
