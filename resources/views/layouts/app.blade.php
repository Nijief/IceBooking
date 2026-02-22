<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ледовый каток')</title>
</head>
<body>
    <header class="header">
        <div class="container header-content">
            <div class="logo">
                <div class="logo-icon"></div>
                <a href="/" class="logo-text">Ice Arena</a>
            </div>
            
            <nav class="nav">
                <a href="/" class="nav-link">Главная</a>
                <a href="#prices" class="nav-link">Цены</a>
                <a href="#skates" class="nav-link">Коньки</a>
                <a href="#contacts" class="nav-link">Контакты</a>
            </nav>

            <div class="header-actions">
                <a href="/ticket" class="btn btn-primary">Купить билет</a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer style="background: var(--dark); color: white; padding: calc(var(--spacing-unit) * 6) 0; margin-top: calc(var(--spacing-unit) * 8);">
        <div class="container">
            <div class="grid grid-3">
                <div>
                    <h4 style="margin-bottom: calc(var(--spacing-unit) * 3);">Ice Arena</h4>
                    <p>Лучший ледовый каток в городе</p>
                </div>
                <div>
                    <h4 style="margin-bottom: calc(var(--spacing-unit) * 3);">Контакты</h4>
                    <p>+7 (999) 123-45-67</p>
                    <p>ул. Ледовая, 1</p>
                </div>
                <div>
                    <h4 style="margin-bottom: calc(var(--spacing-unit) * 3);">Часы работы</h4>
                    <p>Пн-Пт: 10:00 - 22:00</p>
                    <p>Сб-Вс: 09:00 - 23:00</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>