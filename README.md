# Иллюстрации постов в соцсетях

Скрипт работает при условиях:
 * блог в дирректории (например /blog/, /notes/)
 * Установлен CURL
 
 ### Установка
 
1. Скачайте папку ```/ogImage/``` и закиньте ее в корень своего сайта
2. Откройте файл /ogImage/index.php
 - укажите ссылку на блог на 12 строке
 - на строках 75 - 126 настройте цвета и размеры

3. Подключите скрипт в Эгее:
откройте файл /<папка с блогом>/system/theme/templates/head.tmpl.php

найдите код
```
<?php if (array_key_exists ('summary', $content)): ?>
<meta name="description" content="<?= $content['summary'] ?>" />
<?php endif ?>

<?php foreach ($content['og-images'] as $image): ?>
<meta property="og:image" content="<?= $image ?>" />
<?php endforeach ?>

```

и замените его на:

```
<!-- Микроформаты -->
<?php
// Находим картинку, если нет — задаем дефолтную
$my_site = 'https://maksfedorov.ru';
$s = explode("/",$content["notes"]["only"]['href-original']);
$shortLink = $s[5];
if ($shortLink == false){ $shortLink ='default';};

$result_ogimage = $content['og-images'][0];
if ($result_ogimage == $my_site. '/blog/user/userpic@2x.jpg'){
	$result_ogimage = $my_site.'/og_image/?ogimg='.$shortLink;
}
else {
    $result_ogimage = $my_site.'/og_image/?ogimg='.$shortLink;
};
?>

<!-- Open Graph data -->
<meta property="og:image" content="<?= $result_ogimage?>" />
<meta property="og:title" content="<?= $content['title'] ?>" />
<meta property="og:type" content="article" />
<?php if (array_key_exists ('summary', $content)): ?>
<meta name="og:description" content="<?= $content['summary'] ?>" />
<?php endif ?>
<meta property="og:site_name" content="Блог Максима Федорова" />

<!-- Twitter Card data -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@MaFedorov">
<meta name="twitter:creator" content="@MaFedorov">
<meta property="twitter:title" content="<?= $content['title'] ?>">
<?php if (array_key_exists ('summary', $content)): ?>
<meta property="twitter:description" content="<?= $content['summary'] ?>">
<meta property="twitter:image" content="<?= $result_ogimage ?>" />
<?php endif ?>
```
замените на свои данные  аккаунт Твиттера и название сайта