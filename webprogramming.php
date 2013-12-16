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

//������� ����� � ���������� � �������� $_FILES ��� �����

/**
 * ����� ������ ��������� !!!
 *
 * One of the most common mistakes that developers make when dealing with up-
    loaded files is using the name element of the file data array as the destination when
    moving it from its temporary location. Because this piece of information is passed
    by the client, doing so opens up a potentially catastrophic security problem in your
    code. You should, instead, either generate your own file names, or make sure that
    you filter the input data properly before using it (this is discussed in greater detail in
    the Security chapter).

 * ������ <input type="hidden" name="MAX_FILE_SIZE" value="50000" /> - ��� ��� ����� ����� ���� 
 * �������� ����� ����� � ����� ������� ����������� ������������� ������� �����
 * ����� ���������, ��� ������ ������ ������ ��� ������������
 * ��� �������� �����, ����� ��� �����������, ��������� ����� ������������� 
 * ������������

 */

/**
 * ������ ��� ������� �� ����� �� ������������ ���������� ����� ��������� ��� name[]=zero name[]=one
 * � name[one]=one, name[zero]=zero - �.�. ������� � ������������� �������
 */

/**
 * ������ $_FILES �������� ��������� ���������� � �����
 * 
 * name - The original name of the file
 * type - The MIME type of the file provided by the browser
 * size - The size (in bytes) of the file
 * tmp_name - The name of the file�s temporary location
 * error - The error code associated with this file. A value of
        UPLOAD_ERR_OK indicates a successful transfer, while any other
        error indicates that something went wrong (for example, the
        file was bigger than the maximum allowed size).
 * 
 * ������ ������� �� ������� ����� ����� ���� ���������. ���� �� �������� 
 * ��������� ��� ��� � ������� - ���  error ���������� � UPLOAD_ERR_OK
 * � ����� ��������� size � tmp_name �� ����������� � none ��� �� ������
 * � ����� ������������ is_uploaded_file() 
 * ������ �� ������������� ������������ $_FILES['name'] ��� ����� ����
 */

/**
 * header() ������� �� ������ ���� ������� �� ������ ������
 */

/**
 * ��� ��� ������ ��������� ������� ��������� 
 * header("Location: http://phparch.com");
    exit();

  �������� HTTP ������������ gzip ��������� - ������������ �� ����
 ������ ��������� (������� ������, ��� ������) ����� ���� �� 1 �� 9,
 * �� ��������� 6. 1 - ����� ������� � ��� ��� �������������� ������ ������
 * �������� �� ��������� - ������������. ��� �������� ���������� ��� CPU ������
 *
 * �� ������� ������ - ��������� Accept �������� ����������� �� �������� ��������
 * ������� php � ���� ������� ������������ ������, �� ��������� ������� ���������.
 * ��� �������� ����� �������:
 * 1) ob_start("ob_gzhandler");
 * ���
 * 2) ��������� � ini �����: zlib.output_compression = on
                             zlib.output_compression_level = 9
 * ����������� ��� ��� ��� ��������� ���������� ������ �� ���������

����������� , ������ :
 *
 * ��� ��������� �������� ������� �������� �� ���������� ��������� � ������ ���� ��������� ����
 * � ������� �������
 * header("Cache-Control: no-cache, must-revalidate");
   header("Expires: Thu, 31 May 1984 04:35:00 GMT");
  !����� ��� ������ ������� ������������ ��������� ����������� �� ������ ���������
 * � ��� ���� ������:
 * $date = gmdate("D, j M Y H:i:s", time() + 2592000); // 30 Days from now
    header("Expires: " . $data . " UTC");
    header("Cache-Control: Public");
    header("Pragma: Public");
 * ������� �������� ���������� �������� �� ���� ������� + 30 ����.
 * ����� 30 ���� �������� ����� �������������
 */

/**
 * Cookies
 */
// ����  ��������������� �������� setcookie("hide_menu", "1");
// � feel 1)���� ������� ���� ���������� �� ����� ������ �����/headers (��� ����������� ���, � �� ���)
//        2)��������� expire � secure ��� ����� �����/integer � ��� �� ����� ���� ��������� � ������� ������ ������. � ��� ����������� ���� (0)
// ���� ����� ��������� �������������� ���������, ����� ���:
// 1) path - ��������� ������� ���� (������������ ����� ������ �����), ��� ���� ����� ��������, � ���� �� �� �� ���� ����, ��
//           ���� �� ��������. ����� ��� ���� �������� �����, ���� ������ ���� ����� / - ������ ����� �� ����
// 2) domain - ��������� ������������ ������ � ���� �� ������ - �� ������ ���������� ����� ��� ���� ��������,
//              �� ���� ������, �� ������� ����� ����. � �������: ��� ������ shop.uchitsya.com.ua ���������� ���� � �����
//              uchitsya.com.ua �����, � ��� ��� ����� microsoft.com - ������
// 3) secure - ���� 1 - ��� ������ ��� ������� ����� �������� ���� ������ �����
//             ����� ���� �� http ���������

// ����� �������� ����, ����� ��������� � ������ $_COOKIES  � �������� �� ��� $_COOKIES['hide_menu']
// �������� ���� ������ ���� ����������. ������� ����� ����� setcookie ������������� � �������
// ����
$st = setcookie('foobar[0]', 'null'); // � ������� $_COOKIE ����� $_COOKIE[foobar][0]=null
setcookie('foobar[1]', 'one');
setcookie('foobar[2]', 'two');
// ��� ���: (����������� ������!)
setcookie("{foobar['null']}", '0');
setcookie("{foobar['one']}", '1');
setcookie("{foobar['two']}", '2');
// ���������� ������� ������� ������ � ����� � ������������ ������ ����� ������, ��� ����� ��� ����� ������
// ������� ����� � ���(�����) �������, ��������� �������� 4-6 Kb
// ������ "�������" ���� � ������� ������. �� ����� ������ �������������
// ���������������� ���� ����� ������ ���:
setcookie("hide_menu", false, -3600);
// �� ������� �����, � ����������� ��� ���� ������ ��������� � ���� �� �����������,
// � �������� ���� �����������, �.�. �����, � ����
// � ������� ������ � ����� ������ ���� ���������

// ����� �� ������ ���� - ��� �������� � ������� $_COOKIES ������ ��� ������������ ��������
// ������� ��

/**
 * ��� ������� setcooki� ���� ��� ���������:
 * 
 * path � allows you to specify a path (relative to your website�s root) where the
            cookie will be accessible; the browser will only send a cookie to pages within
            this path.
 * domain � allows you to limit access to the cookie to pages within a specific do-
            main or hostname; note that you cannot set this value to a domain other than
            the one of the page setting the cookie (e.g.: the host www.phparch.com can set a
            cookie for hades.phparch.com, but not for www.microsoft.com).
 * secure � this requests that the browser only send this cookie as part of its re-
            quest headers when communicating under HTTPS.

 * ���� � ��� ����� php.com �� �� �� ������ ��������� ���� ��� ������� google.com
 * �� ��� ��������� dev.php.com - ����������.
 */

// SESSIONS
/*
 * ��������
 * session.use_trans_sid
   ��������� �������� �������������� ������ ����� url � ����� ������� ������� 
 * ���� �� ������� � php 5
 * �� ��������
 *
 * ������ �������� � � ��� �����. ������������� ������ � �����. �� ������� � �����
 * tmp ����� ���� � ������ �������������� ������ � � ��� �������� ��� ����������� ��������
 * ��� ���� - ��������
 *
 * ������ �������� ����� ���������:
 * 1) ���� �������� � php.ini ����� session.auto_start �� ����� ������ ��������
 *    ������ ��� ������ �������, �.�. session_start() ����������
 *    "������� ������� �������" ��� ��������
 * 2) ���� ������ ��������� session_start ��������������� � ���� ����������
 *
 * ��� ������ ����� ���� �����������:
 * � ����� ������ ����� ������ ����������� ������������� - ��� ����� �������� �� ������
 * �� ���� � �����: ������ ����������� �� ����, ��� ��������� ��� ��� ������, ��. � �����
 * ������ ���������� �������, ��� ������ ����������� ���������� �������� � ������
 * ��������� ��� �������� ����� ������.
 *
 * ! ������ � ��������� ������������ ����� ������ ��� ���: �������������� ���� ������
 * ����������� ������ session_regenerate_id(), ����� ������������� �����: ���� �������������� ������
 * php.net: session_regenerate_id() - will replace the current session id with a new one, and keep the current session information.
 *  session_regenerate_id() ���������� true ��� ������� ���������� � false ��� ���������
 *
   ������ � ������ ������ �������������� ����� ��������������� ������ $_SESSION
   � ������� �� ������ �������� �� ����� ����� ����������
 */