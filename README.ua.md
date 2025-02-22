# Calories365: Лічильник калорій з Telegram-ботом та ШІ

**Calories365** — це веб-додаток та Telegram-бот, які дозволяють зручно вести щоденник харчування, автоматично обробляти голосові повідомлення та отримувати статистику по калоріях (за допомогою ШІ).

## [Спробуйте Щоденник Калорій зараз!](https://calculator.calories365.com)

---

## 1. Суть проекту

> **Запишіть свою їжу та дізнайтеся, скільки калорій ви споживаєте.**

- **Щоденник калорій**  
  У нашому веб-додатку ви можете фіксувати все, що ви з'їли за день. Знайдіть продукт у широкій базі або додайте свій варіант — будуть враховані будь-які індивідуальні страви та інгредієнти.

- **Наглядна статистика**  
  Відстежуйте динаміку споживання калорій за різні періоди. Ви легко зрозумієте, якщо регулярно перевищуєте норму або, навпаки, вміщаєтесь у рекомендовані показники.

- **Telegram-бот**  
  Підключіть бота через особистий кабінет та вносьте дані **голосом**:
    1. Назвіть продукт — бот переведе ваш голос у текст та сформує список страв.
    2. Якщо ви не уточнили вагу, бот запропонує середньостатистичні значення або згенерує КБЖУ за допомогою штучного інтелекту.
    3. За необхідності внесіть корективи та одним натисканням збережіть запис у щоденнику.

- **Економія часу**  
  Не потрібно відкривати сайт або встановлювати додатковий додаток — достатньо Telegram. Завжди під рукою щоденна статистика та швидкий введення даних.

Таким чином, якщо ваша мета — **швидко** та **просто** рахувати калорії, «Calories365» разом із нашим ботом стане чудовим рішенням.

---

## 2. Використовувані технології

- **Laravel** (з підключеними пакетами **Laravel Sanctum** та **Laravel Fortify** для автентифікації та безпеки)
- **MySQL** — СУБД для зберігання даних (користувачі, продукти, щоденник).
- **Redis** — кешування та зберігання сесій.
- **Meilisearch** — пошук по базі продуктів.
- **Telegram SDK** — інтеграція з Telegram.
- **FFmpeg** — конвертація аудіо/відео (особливо при обробці голосових повідомлень).
- **Vue.js** — фронтенд-фреймворк (SPA + динамічні форми/таблиці).
- **OAuth** — протокол для авторизації (для входу через Google).
- **Docker** — контейнеризація та оркестрація (PHP-FPM, Nginx, MySQL, Redis).
- **Cloudflare** — проксіювання та додатковий захист на рівні DNS/SSL.

---

## 3. Архітектурні особливості

### 3.1 Backend архітектура для Telegram-ботів

У проекті є окрема «Bot Panel», яка реалізує **сервісний шар** (Service Layer) для управління ботами. Крім того, **Bot Panel** функціонує як адмін-панель, де можна:

- **Додавати** та **конфігурувати** Telegram-ботів,
- **Моніторити** користувачів та ботів,
- Взаємодіяти з логікою обробки повідомлень через зручний веб-інтерфейс.

Основні моменти сервісного шару:
1. **Контролер** приймає Update від Telegram → передає у `TelegramHandler`.
2. **TelegramHandler** визначає, який бот (стратегія) використовується, пропускає дані через мідлвари (Laravel Pipeline) та викликає відповідну логіку.
3. **Стратегії** (наприклад, `CaloriesService`) наслідують базовий клас (`BaseService`), де реєструються хендлери:
    - `MessageUpdateHandler` (обробка текстів, голосових, картинок)
    - `CallbackQueryHandler` (обробка inline-кнопок)
    - та інші.

Це забезпечує гнучкість додавання нових ботів та розширень.  
**Детальніше**: [Див. окремий README по сервісному шару ботів](./README.BotPanelArchitecture.ua.md)

### 3.2 Динамічні форми та таблиці на Vue

Для фронтенду розроблені **універсальні** компоненти:
- Форми будуються на основі конфігів: кожен об'єкт задає поле (тип, плейсхолдер, обов'язковість тощо).
- Таблиці також налаштовуються конфігами: кожен об'єкт у масиві описує стовпець (назва, тип клітинки, ліміт символів та інше).

Це дає можливість без зміни коду компонентів додавати або видаляти поля та стовпці.  
**Детальніше**: [Див. окремий README по динамічним формам/таблицям](./README.DynamicFormsAndTables.ua.md)

---

## 4. Середовище розробки

- **Модифікований Laradock**: єдине середовище з PHP-FPM, Node.js, MySQL, Redis, Meilisearch тощо.
- **Ngrok**: віддалений доступ до локального сервера (Telegram Webhook може надходити на локальну машину).
- **FFmpeg**: встановлений для перетворення/аналізу медіафайлів (голосові повідомлення).

---

## 5. CI/CD та деплой на сервер

### Коротко про налаштування

- Розгортання здійснюється на **власному сервері**, налаштованому під Cloudflare (DNS/SSL).
- **Docker + docker-compose**: для кожного додатку (Calories365 та Bot Panel) є набір контейнерів (PHP, Nginx, Redis, MySQL тощо). Сервіси спілкуються через **внутрішню мережу Docker**.
- **GitHub Actions**: при пуші в `main` автоматично спрацьовує деплой на сервер та збірка для продакшну.

### Деталі

- У кожному з **двох сервісів** (Calories365 та Bot Panel) присутні:
    - **Dockerfile**, що використовує багатоступеневу збірку (PHP, Node/Vite, Nginx).
    - **docker-compose.yml**, описуючий контейнери та їх залежності.
    - **nginx.conf**, що задає віртуальний хост (серверні блоки) для кожного сервісу.

---

## 6. Висновок

**Calories365** — універсальний інструмент для підрахунку калорій та контролю свого раціону:
- **Telegram-бот** економить ваш час завдяки голосовому вводу даних.
- **Веб-додаток** надає наочну статистику, широку базу продуктів та зручний інтерфейс.
- **Bot Panel** служить адмінкою для ботів та забезпечує гнучку настройку логіки Telegram, а також моніторинг користувачів.
- **Архітектура** (мікросервіси всередині Docker, гнучкі конфіги, CI/CD) спрощує подальший розвиток та масштабування.

Якщо вам потрібно **швидко** та **комфортно** стежити за харчуванням — наш проект «Calories365» з Telegram-ботом та динамічним веб-кабінетом ідеально підійде для цих завдань!

---

> **Додатково**:
> - [**Архітектура сервісного шару (Bot Panel)**](./README.BotPanelArchitecture.ua.md)
> - [**Динамічні форми та таблиці на Vue**](./README.DynamicFormsAndTables.ua.md)  
