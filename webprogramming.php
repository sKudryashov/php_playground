<?php
/**
 * webprogramming part of the certification
 */
// !if we get data from $_GET, no need to make urldecode, its
// been making automatically by interpreter

// data from both $_GET and $_POST  and cookies arrays can contains in $_REQUOEST
// note that data from environment variables DOESNT contains
// in this array

// management of input filesize is by using php directives as
// post_max_size, max_input_time, and upload_max_filesize

//создать форму и поработать с массивом $_FILES для теста

/**
 * Очень важное замечание !!!
 *
 * One of the most common mistakes that developers make when dealing with up-
    loaded files is using the name element of the file data array as the destination when
    moving it from its temporary location. Because this piece of information is passed
    by the client, doing so opens up a potentially catastrophic security problem in your
    code. You should, instead, either generate your own file names, or make sure that
    you filter the input data properly before using it (this is discussed in greater detail in
    the Security chapter).

 * Кстати <input type="hidden" name="MAX_FILE_SIZE" value="50000" /> - вот эта штука может быть 
 * передана через форму и таким образом ограничение максимального размера файла
 * будет перекрыто, что вообще говоря угроза для безопасности
 * При загрузке файла, после его перемещения, временная копия автоматически 
 * уничтожается

 */

/**
 * Кстати нас конечно же ничто не ограничивает передавать такие структуры как name[]=zero name[]=one
 * и name[one]=one, name[zero]=zero - т.е. обычные и ассоциативные массивы
 */

/**
 * Массив $_FILES содержит следующую информацию о файле
 * 
 * name - The original name of the file
 * type - The MIME type of the file provided by the browser
 * size - The size (in bytes) of the file
 * tmp_name - The name of the file’s temporary location
 * error - The error code associated with this file. A value of
        UPLOAD_ERR_OK indicates a successful transfer, while any other
        error indicates that something went wrong (for example, the
        file was bigger than the maximum allowed size).
 * 
 * Кстати запросы на закачку файла могут быть подделаны. Один из способов 
 * убедиться что все в порядке - это  error установлен в UPLOAD_ERR_OK
 * а также ненулевой size и tmp_name не установлено в none или не пустое
 * а также использовать is_uploaded_file() 
 * Кстати не рекомендуется использовать $_FILES['name'] как часть пути
 */

/**
 * header() конечно же должна быть вызвана ДО любого вывода
 */

/**
 * Вот это кстати считается хорошей практикой 
 * header("Location: http://phparch.com");
    exit();

  Протокол HTTP поддерживает gzip архивацию - разархивацию на лету
 уровни архивации (степень сжатия, так точнее) могут быть от 1 до 9,
 * по умолчанию 6. 1 - самый меньший и при нем соответственно меньше уходит
 * ресурсов на архивацию - разархивацию. это довольно трудоемкая для CPU задача
 *
 * По методам сжатия - заголовки Accept браузера принимаются во внимание интерпре
 * татором php и если браузер поддерживает сжатие, то исходящий траффик сжимается.
 * Это делается таким образом:
 * 1) ob_start("ob_gzhandler");
 * или
 * 2) установка в ini файле: zlib.output_compression = on
                             zlib.output_compression_level = 9
 * естественно что код для установки компрессии менять не требуется

кэширование , пример :
 *
 * Эти заголовки например говорят браузеру НЕ кэшировать страничку и ставят срок истечения кэша
 * в далеком прошлом
 * header("Cache-Control: no-cache, must-revalidate");
   header("Expires: Thu, 31 May 1984 04:35:00 GMT");
  !пишут что каждый браузер воспринимает директивы кэширования со своими причудами
 * А вот этот пример:
 * $date = gmdate("D, j M Y H:i:s", time() + 2592000); // 30 Days from now
    header("Expires: " . $data . " UTC");
    header("Cache-Control: Public");
    header("Pragma: Public");
 * Говорит браузеру кэшировать страницу на срок сегодня + 30 дней.
 * Через 30 дней страница будет перезагружена
 */

/**
 * Cookies
 */
// кука  устанавливается функцией setcookie("hide_menu", "1");
// с feel 1)Куки обязаны быть отправлены до любых других шапок/headers (это ограничение кук, а не РНР)
//        2)Аргументы expire и secure это целые числа/integer и они не могут быть пропущены с помощью пустой строки. В них используйте нуль (0)
// кука может принимать дополнительные параметры, такие как:
// 1) path - позволяет указать путь (относительно корня вашего сайта), где куки будут доступны, и если ты не на этом пути, то
//           куки не доступны. Чтобы они были доступны везде, путь должен быть таким / - корень сайта то есть
// 2) domain - позволяет ограничивать доступ к куки по домену - но нельзя установить домен для куки отличный,
//              от того домена, на котором висит сайт. К примеру: для домена shop.uchitsya.com.ua установить куку с сайта
//              uchitsya.com.ua можно, а вот для сайта microsoft.com - нельзя
// 3) secure - если 1 - это значит что браузер может посылать куки только когда
//             связь идет по http протоколу

// чтобы получить куку, нужно заглянуть в массив $_COOKIES  и получить ее так $_COOKIES['hide_menu']
// значения куки должны быть скалярными. Конечно можно через setcookie устанавливать и массивы
// типа
$st = setcookie('foobar[0]', 'null'); // В массиве $_COOKIE стоит $_COOKIE[foobar][0]=null
setcookie('foobar[1]', 'one');
setcookie('foobar[2]', 'two');
// или так: (попробовать кстати!)
setcookie("{foobar['null']}", '0');
setcookie("{foobar['one']}", '1');
setcookie("{foobar['two']}", '2');
// желательно хранить минимум данных в куках и использовать вместо этого сессию, тем более что объем данных
// которые можно в них(куках) хранить, ограничен размером 4-6 Kb
// Просто "удалить" куку с клиента нельзя. Ее можно только разустановить
// разустанавливать куки можно только так:
setcookie("hide_menu", false, -3600);
// по другому никак, и естественно что куки должны удаляться с теми же параметрами,
// с которыми были установлены, т.е. домен, и путь
// и конечно данные в куках должны быть скалярами

// КОгда мы ставим куку - она доступна в массиве $_COOKIES только при перезагрузке страницы
// конечно же

/**
 * Для функции setcookiе есть три аргумента:
 * 
 * path — allows you to specify a path (relative to your website’s root) where the
            cookie will be accessible; the browser will only send a cookie to pages within
            this path.
 * domain — allows you to limit access to the cookie to pages within a specific do-
            main or hostname; note that you cannot set this value to a domain other than
            the one of the page setting the cookie (e.g.: the host www.phparch.com can set a
            cookie for hades.phparch.com, but not for www.microsoft.com).
 * secure — this requests that the browser only send this cookie as part of its re-
            quest headers when communicating under HTTPS.

 * Если у нас домен php.com то мы не сможем поставить куки для домента google.com
 * но для поддомена dev.php.com - пожалуйста.
 */

// SESSIONS
/*
 * Параметр
 * session.use_trans_sid
   разрешает передачу идентификатора сессии через url В КОНЦЕ КАЖДОГО ЗАПРОСА 
 * хотя по дефолту в php 5
 * он выключен
 *
 * Вообще механизм я и так помню. Идентификатор сессии в куках. НА сервере в папке
 * tmp лежит файл с именем идентификатора сессии и в нем хранятся все необходимые значения
 * как ключ - значение
 *
 * Сессии стартуют двумя способами:
 * 1) если включена в php.ini опция session.auto_start то тогда сессия стартует
 *    вообще при каждом запросе, т.е. session_start() вызывается
 *    "вначале каждого скрипта" как написано
 * 2) либо просто запускать session_start непосредственно в коде приложения
 *
 * Оба похода имеют свои особенности:
 * в одном случае когда сессия запускается автоматически - нет нужды вызывать ее руками
 * но есть и минус: сессия запускается до того, как загружены все мои классы, те. в самом
 * начале выполнения скрипта, что делает невозможным сохранение объектов в сессии
 * поскольку они грузятся после старта.
 *
 * ! кстати в интересах безопасности можно делать вот что: регенерировать айди сессии
 * посредством вызова session_regenerate_id(), чтобы предотвратить атаку: угон идентификатора сессии
 * php.net: session_regenerate_id() - will replace the current session id with a new one, and keep the current session information.
 *  session_regenerate_id() возвращает true при удачном выполнении и false при неудачном
 *
   Доступ к данным сессии осуществляется через суперглобальный массив $_SESSION
   и конечно же сессия стартует до ухода любых заголовков
 */