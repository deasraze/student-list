<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $response->getStatusCode() ?> <?= $response->getStatusPhrase() ?></title>
    <link rel="icon" href="favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
    <link rel="stylesheet" href="/css/error.css">
</head>
<body>
<div class="error">
    <div class="error__inner">
        <div class="basic__error">
            <div class="error__info">
                <h1 class="error-title"><?= $response->getStatusCode() ?></h1>
                <h2 class="error-subtitle"><?= $response->getStatusPhrase() ?></h2>
            </div>
            <div class="error__description">
                <p>Oops..
                    <?php if (method_exists($exception, 'getDescription')): ?>
                        <?= $exception->getDescription() ?>
                    <?php else: ?>
                        An error occurred. Please try again or contact your server administrator.
                    <?php endif; ?>
                </p>
            </div>
        </div>
        <a class="btn-home" href="/">Homepage</a>
        <?php if (ini_get('display_errors') === '1'): ?>
        <div class="developer__error">
            <div class="developer__info">
                <p>Exception type: <?= get_class($exception) ?></p>
                <p>Thrown at: <?= $exception->getFile() ?></p>
                <p>With message: <?= $exception->getMessage() ?></p>
            </div>
            <div class="stack-trace">
                <p><?= nl2br($exception->getTraceAsString()) ?></p>
            </div>
        </div>
        <?php endif; ?>
        <div class="contacts">
            <p>Made with <span class="contacts__heart">&hearts; </span>
                by <span class="contacts__author">theifel</span>
            </p>
            <div class="contacts__github">
                <p>Licensed under <a class="license-link" href="">MIT license</a></p>
                <p>Source code on GitHub:
                    <a class="github-link"
                       href="https://github.com/theifel/student-list" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             width="32" height="32" fill="currentColor"
                             class="bi bi-github" viewBox="0 0 16 16">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                        </svg>
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
</body>
</html>