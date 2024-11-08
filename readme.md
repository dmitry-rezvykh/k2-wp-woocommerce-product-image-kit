# Набор для добавления в вашу тему галереи фотографий для Woocommerce товара

В этом наборе все необходимое, а также ниже - подробные инструкции как добавить слайдер и галерею фотографий в вашу тему.

В тему bootscore-child в шаблоне (https://github.com/k2tool-wp/wp-template) - этот функционал встроен по умолчанию, дополнительных действий не требуется.

Впервые подход использован на сайте heden.ru.

## Что необходимо
- Wordpress Bedrock (инструкция подразумевает, что WordPress сайт построен на нем)
- Основная тема и дочерняя тема (все новые стили и скрипты будем добавлять в дочернюю тему, если она не используется - нуно ее создать)
- В дочерней теме стили должны собираться с помощью SCSS препроцессора (через Gulp например)

## Инструкция по установке

1. положить в дочернюю тему файл product-image.php по адресу woocommerce/single-product/product-image.php
2. в файле function.php дополнить функцию которая подключает нужные нам js и css файлы (все что внутри if (is_product()) {})
3. подключить к файлу functions.php файл с другими необходимыми функциями - inc/_woo-product-image.php
4. в папке дочерней темы создать файл .gitignore и скопировать туда содержимое аналогичного файла в репозитории
5. в папке дочерней темы создать папку assets и в нее скопировать папки из репозитория (обычно такая папка уже есть, просто проверьте пути, чтобы все подключалось откуда надо, scss файлы подключить в общий файл)
6. для scss файлов проверьте переменные - если такие в вашем проекте уже используются - надо будет либо переименовать, либо просто удалить ненужные из файла _variables.scss
7. в файл composer.json в корне сайта нужно добавить в раздел post-update-cmd в блоке scripts команды (должно получиться примерно так):

``` json
"scripts": {
    "post-update-cmd": [
      "cp vendor/npm-asset/swiper/swiper-bundle.min.css web/app/themes/bootscore-child-main/assets/css",
      "cp vendor/npm-asset/swiper/swiper-bundle.min.js web/app/themes/bootscore-child-main/assets/js",
      "cp vendor/npm-asset/photoswipe/dist/photoswipe.css web/app/themes/bootscore-child-main/assets/css",
      "cp vendor/npm-asset/photoswipe/dist/umd/photoswipe-lightbox.umd.min.js web/app/themes/bootscore-child-main/assets/js",
      "cp vendor/npm-asset/photoswipe/dist/umd/photoswipe.umd.min.js web/app/themes/bootscore-child-main/assets/js"
    ],
    "test": [
      "phpcs"
    ]
  }
```

8. в раздел repositories добавить

``` json
{
    "type": "composer",
    "url": "https://asset-packagist.org"
},
```

8. установить пакеты командой ```composer require npm-asset/photoswipe npm-asset/swiper```

### Возможные ошибки

Если используется тема bootsсore, то могут перезаписываться часть стилей у пакета photoswipe, чтобы это обойти нужно стили фотосвайпа поставить выше чем основные стили вот так (в файле functions.php)

``` php
    // Compiled main.css
    $modified_bootscoreChildCss = date('YmdHi', filemtime(get_stylesheet_directory() . '/assets/css/main.css'));
    wp_enqueue_style('main', get_stylesheet_directory_uri() . '/assets/css/main.css', is_product() ? ['parent-style', 'photoswipe-5'] : ['parent-style'], $modified_bootscoreChildCss);
```

