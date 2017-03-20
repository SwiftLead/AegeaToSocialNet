<?php

require_once('./PHPImage.php');



/*
 * Настройки
*/

// Адрес блога
$our_blog = 'http://derivanov.ru/blog';

//Исходный шаблон (1200 х 630 пкс)
$bg = './img/template.jpg';

// Логотип
$overlay = './img/userpick.png';

// Название блога
$blog_name = 'Блог Максима Федорова';

// Заголовок поста  (обязательно)
$post_title = 'Блог Максима Федорова';

// Превращаем из УРЛА в переменную
//$shortLink = 'cena-teksta-za-1000-simvolov';
$shortLink = $_GET["ogimg"];



/*--------------------------------------------------------------
* Парсим заголовок
*--------------------------------------------------------------/
*/

$url = $our_blog.'/all/'.$shortLink.'/'; // собираем наш адрес
$my_html = isDomainAvailible($url);

preg_match_all('#<title>(.+?)</title>#',$my_html,$toTitle);

if($toTitle){
    $post_title = $toTitle[1][0];
}
else{
    echo 'Нет тайтла или не получилось спарсить.';
}

//print $post_title;


//Возвращает true, если домен доступен
function isDomainAvailible($domain)
{
    //Инициализация curl
    $curlInit = curl_init($domain);
    curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlInit, CURLOPT_HEADER, false);

    // Включить для https://
    //curl_setopt($curlInit, CURLOPT_SSL_VERIFYHOST, false);
    //curl_setopt($curlInit, CURLOPT_SSL_VERIFYPEER, false);

    //Получаем ответ
    $response = curl_exec($curlInit);

    curl_close($curlInit);
    return $response;
}





/*--------------------------------------------------------------
 * Генерация изображения
*/
$image = new PHPImage();


$image->setDimensionsFromImage($bg);
$image->draw($bg);

//$image->setFont('./font/arial.ttf');
$image->setFont('./font/pt-sans-caption.ttf');
//$image->setFont('./font/GraphikLC-Bold-Web.ttf');

// Цвет шрифта
$image->setTextColor(array(0, 0, 0));
$image->setStrokeWidth(1);

// Тень у шрифта
$image->setStrokeColor(array(255, 255, 255),0);

// Бекграунд (x, y, ширина, высота, фон)
$image->rectangle(0, 0, 1200, 630, array(227, 241, 252), 1);

// Выводим логотип
//$image->draw($overlay, 50, 50);

// Название блога
if ($blog_name) {
        $image->textBox($blog_name, array(
            'width' => 700,
            'height' => 400,
            'fontSize' => 20, // Desired starting font size
            'x' => 85,
            'y' => 85
        ));
      }

// Тень у шрифта
$image->setStrokeColor(array(0, 0, 0));
// Тема поста
$image->textBox($post_title, array(
    'width' => 900,
    'height' => 400,
    'fontSize' => 45, // Desired starting font size
    'x' => 175,
    'y' => 210
));


$image->show();

//$image->resize(1200, 630, 0, 0)->show();
