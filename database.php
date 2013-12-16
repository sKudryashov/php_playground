<?
/**
 * Database chapter 
 */
// Точные переводы по типам связей между таблицами
/**
 * 1-to-1 - в крайнем случае одна строка в подчиненной таблице
 *          может соответствовать одной строке в родительской
 *          (Или одна или ноль, насколько я понимаю)
 * 1 to many - произвольное число строк в подчиненной таблице может соотв
 *              одной строке в родительской
 * many tp many - произвольное число строк в подчиенной таблице может соответствовать
 *                  произвольному числу строк в родительской
 * Пишут, что если у меня в скрипте много знаков после запятой, больше чем преду
 * смотрено в таблице бд - я получу warning. Ну что ж.. .
 * тип char - строки фиксированной длины (если символов не хватает, строка в таблице заполняется пробелами
 * до указанной длины)
 * тип varchar - строки переменной длины обычно 1-255
 * строки, превышающие лимит обрезаются без warning
 * Тип BLOB используется для хранения бинарных данных, поскольку строки в бд это именно строки
 * а не наборы бинарных данных
 * пишут что все манипуляции с датой лучше проводить на уровне БД
 * NULL в mysql означает что эта колонка не содержит данных
 * И колонка которая NULL конечно же не может быть primary key
 *
 * Синтаксис создания БД:
 * CREATE DATABASE <dbname>
 * ИЛИ
 * CREATE SCHEMA <dbname>
 *
 * Синтаксис создания таблицы:
 * CREATE TABLE <tablename> (
 * <col1name> <col1type> [<col1attributes>],
 * [ ...
 * <colnname> <colntype> [<colnattributes>]]
 * )
 *
 * ИЛИ ТАК
 *
 * CREATE TABLE book (
    id INT NOT NULL PRIMARY KEY,
    isbn VARCHAR(13),
    title VARCHAR(255),
    author VARCHAR(255),
    publisher VARCHAR(255)
    )

СИнтаксис создания индекса:
 * CREATE INDEX <indexname>
ON <tablename> (<column1>[, ..., <columnn>])

ПРИМЕР
 *
 * CREATE INDEX book_isbn ON book (isbn)

Создание таблицы с one to many зависимостью (подчиненной таблицы конечно)
CREATE TABLE book_chapter (
isbn VARCHAR(13) REFERENCES book (id),
chapter_number INT NOT NULL,
chapter_title VARCHAR(255)
)

 * Дропать можно таблицы, базы и ключи
   DROP TABLE book_chapter
   Понятно что если дропаемая таблица имеет связь и является подчиненной
   то она никуда не удалится, пока не удалится главная таблица\,
   это для сохранения целостности данных
 *
 * По инсерту: есть два варианта инсерта,
 * 1) INSERT INTO table VALUES ('val1', 'val2', 'val3');
 * и
 * 2) INSERT INTO table (`col1`, `col2`, `col3`) VALUES ('val1', 'val2', 'val3');
 * В первом случае обязательно указывать все поля таблицы. Во втором случае необязательно
 * указывать все поля таблицы. Это хорошо и нужно для тех случаев, когда некоторые поля
 * не нужно указывать вообще (типа таймшамп), они могут бросить error
 *
 * UPDATE book SET publisher = ’Tor Science Fiction’;
   апдейтит все записи в таблице
 *
 * UPDATE book
    SET publisher = ’Tor Science Fiction’, author = ’Orson S. Card’
    WHERE isbn = ’0812550706’;
 * Апдейтит определенную запись в таблице (интересно, условия OR и AND работают в этом случае?) 

 *Удаление из бд DELETE FROM book; - удаляет все записи из таблицы
 *
 * Удаляет конкретную запись из таблицы DELETE FROM book WHERE isbn = ’0812550706’;


 */

/**
 * Образец транзакции
 * 
 * START TRANSACTION
   DELETE FROM book WHERE isbn LIKE ’0655%’
   UPDATE book_chapter set chapter_number = chapter_number + 1
   ROLLBACK
   START TRANSACTION
   UPDATE book SET id = id + 1
   DELETE FROM book_chapter WHERE isbn LIKE ’0433%’
   COMMIT
 */

// Отдельная тема это PDO Object
// Обратить внимание на формат записи $dsn в PDO
// Для соединения через сокет нужно сделать это так:
//  $dsn = 'mysql:dbname=testdb;unix_socket=/path/to/socket';
$pdo = new PDO('mysql:dbname=testdb;host=127.0.0.1', 'root', '333888');
//Кстати драйверы  PDO могут быть вот такими:
/*
CUBRID (PDO) — CUBRID Functions (PDO_CUBRID)
MS SQL Server (PDO) — Microsoft SQL Server and Sybase Functions (PDO_DBLIB)
Firebird/Interbase (PDO) — Firebird/Interbase Functions (PDO_FIREBIRD)
IBM (PDO) — IBM Functions (PDO_IBM)
Informix (PDO) — Informix Functions (PDO_INFORMIX)
MySQL (PDO) — MySQL Functions (PDO_MYSQL)
MS SQL Server (PDO) — Microsoft SQL Server Functions (PDO_SQLSRV)
Oracle (PDO) — Oracle Functions (PDO_OCI)
ODBC and DB2 (PDO) — ODBC and DB2 Functions (PDO_ODBC)
PostgreSQL (PDO) — PostgreSQL Functions (PDO_PGSQL)
SQLite (PDO) — SQLite Functions (PDO_SQLITE)
4D (PDO)
* 
*/ 
/**
 * Доступные методы:
 * __construct ( string $dsn [, string $username [, string $password [, array $driver_options ]]] )
    bool beginTransaction ( void )
    bool commit ( void )
    mixed errorCode ( void )
    array errorInfo ( void )
    int exec ( string $statement )
    mixed getAttribute ( int $attribute )
    array getAvailableDrivers ( void )
    bool inTransaction ( void )
    string lastInsertId ([ string $name = NULL ] )
    PDOStatement prepare ( string $statement [, array $driver_options = array() ] )
    PDOStatement query ( string $statement )
    string quote ( string $string [, int $parameter_type = PDO::PARAM_STR ] )
    bool rollBack ( void )
    bool setAttribute ( int $attribute , mixed $value )
 */
// когда  SELECT запрос выполняется - мы получаем PDOStatement объект в качестве ответа
// а в нем доступны уже следующие методы:
/**
 *  
    PDOStatement->bindColumn — Bind a column to a PHP variable
 *  Since information about the columns is not always available to PDO until the statement is executed, 
 *  portable applications should call this function after PDOStatement::execute(). 
 * 
    PDOStatement->bindParam — Binds a parameter to the specified variable name
    PDOStatement->bindValue — Binds a value to a parameter
    PDOStatement->closeCursor — Closes the cursor, enabling the statement to be executed again.
    PDOStatement->columnCount — Returns the number of columns in the result set
    PDOStatement->debugDumpParams — Dump an SQL prepared command
    PDOStatement->errorCode — Fetch the SQLSTATE associated with the last operation on the statement handle
    PDOStatement->errorInfo — Fetch extended error information associated with the last operation on the statement handle
    PDOStatement->execute — Executes a prepared statement
    PDOStatement->fetch — Fetches the next row from a result set
    PDOStatement->fetchAll — Returns an array containing all of the result set rows
    PDOStatement->fetchColumn — Returns a single column from the next row of a result set
    PDOStatement->fetchObject — Fetches the next row and returns it as an object.
    PDOStatement->getAttribute — Retrieve a statement attribute
    PDOStatement->getColumnMeta — Returns metadata for a column in a result set
    PDOStatement->nextRowset — Advances to the next rowset in a multi-rowset statement handle
    PDOStatement->rowCount — Returns the number of rows affected by the last SQL statement
    PDOStatement->setAttribute — Set a statement attribute
    PDOStatement->setFetchMode — Set the default fetch mode for this statement
 */
/**
 * Работает примерно следующим образом:
 * 
 * function readData($dbh) {
      $sql = 'SELECT name, colour, calories FROM fruit';
      try {
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        //Bind by column number 
        $stmt->bindColumn(1, $name);
        $stmt->bindColumn(2, $colour);

        // Bind by column name 
        $stmt->bindColumn('calories', $cals);

        while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
          $data = $name . "\t" . $colour . "\t" . $cals . "\n";
          print $data;
        }
      }
      catch (PDOException $e) {
        print $e->getMessage();
      }
    }
    readData($dbh);
 * 
 */