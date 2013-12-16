<?
/**
 * Database chapter 
 */
// ������ �������� �� ����� ������ ����� ���������
/**
 * 1-to-1 - � ������� ������ ���� ������ � ����������� �������
 *          ����� ��������������� ����� ������ � ������������
 *          (��� ���� ��� ����, ��������� � �������)
 * 1 to many - ������������ ����� ����� � ����������� ������� ����� �����
 *              ����� ������ � ������������
 * many tp many - ������������ ����� ����� � ���������� ������� ����� ���������������
 *                  ������������� ����� ����� � ������������
 * �����, ��� ���� � ���� � ������� ����� ������ ����� �������, ������ ��� �����
 * �������� � ������� �� - � ������ warning. �� ��� �.. .
 * ��� char - ������ ������������� ����� (���� �������� �� �������, ������ � ������� ����������� ���������
 * �� ��������� �����)
 * ��� varchar - ������ ���������� ����� ������ 1-255
 * ������, ����������� ����� ���������� ��� warning
 * ��� BLOB ������������ ��� �������� �������� ������, ��������� ������ � �� ��� ������ ������
 * � �� ������ �������� ������
 * ����� ��� ��� ����������� � ����� ����� ��������� �� ������ ��
 * NULL � mysql �������� ��� ��� ������� �� �������� ������
 * � ������� ������� NULL ������� �� �� ����� ���� primary key
 *
 * ��������� �������� ��:
 * CREATE DATABASE <dbname>
 * ���
 * CREATE SCHEMA <dbname>
 *
 * ��������� �������� �������:
 * CREATE TABLE <tablename> (
 * <col1name> <col1type> [<col1attributes>],
 * [ ...
 * <colnname> <colntype> [<colnattributes>]]
 * )
 *
 * ��� ���
 *
 * CREATE TABLE book (
    id INT NOT NULL PRIMARY KEY,
    isbn VARCHAR(13),
    title VARCHAR(255),
    author VARCHAR(255),
    publisher VARCHAR(255)
    )

��������� �������� �������:
 * CREATE INDEX <indexname>
ON <tablename> (<column1>[, ..., <columnn>])

������
 *
 * CREATE INDEX book_isbn ON book (isbn)

�������� ������� � one to many ������������ (����������� ������� �������)
CREATE TABLE book_chapter (
isbn VARCHAR(13) REFERENCES book (id),
chapter_number INT NOT NULL,
chapter_title VARCHAR(255)
)

 * ������� ����� �������, ���� � �����
   DROP TABLE book_chapter
   ������� ��� ���� ��������� ������� ����� ����� � �������� �����������
   �� ��� ������ �� ��������, ���� �� �������� ������� �������\,
   ��� ��� ���������� ����������� ������
 *
 * �� �������: ���� ��� �������� �������,
 * 1) INSERT INTO table VALUES ('val1', 'val2', 'val3');
 * �
 * 2) INSERT INTO table (`col1`, `col2`, `col3`) VALUES ('val1', 'val2', 'val3');
 * � ������ ������ ����������� ��������� ��� ���� �������. �� ������ ������ �������������
 * ��������� ��� ���� �������. ��� ������ � ����� ��� ��� �������, ����� ��������� ����
 * �� ����� ��������� ������ (���� ��������), ��� ����� ������� error
 *
 * UPDATE book SET publisher = �Tor Science Fiction�;
   �������� ��� ������ � �������
 *
 * UPDATE book
    SET publisher = �Tor Science Fiction�, author = �Orson S. Card�
    WHERE isbn = �0812550706�;
 * �������� ������������ ������ � ������� (���������, ������� OR � AND �������� � ���� ������?) 

 *�������� �� �� DELETE FROM book; - ������� ��� ������ �� �������
 *
 * ������� ���������� ������ �� ������� DELETE FROM book WHERE isbn = �0812550706�;


 */

/**
 * ������� ����������
 * 
 * START TRANSACTION
   DELETE FROM book WHERE isbn LIKE �0655%�
   UPDATE book_chapter set chapter_number = chapter_number + 1
   ROLLBACK
   START TRANSACTION
   UPDATE book SET id = id + 1
   DELETE FROM book_chapter WHERE isbn LIKE �0433%�
   COMMIT
 */

// ��������� ���� ��� PDO Object
// �������� �������� �� ������ ������ $dsn � PDO
// ��� ���������� ����� ����� ����� ������� ��� ���:
//  $dsn = 'mysql:dbname=testdb;unix_socket=/path/to/socket';
$pdo = new PDO('mysql:dbname=testdb;host=127.0.0.1', 'root', '333888');
//������ ��������  PDO ����� ���� ��� ������:
/*
CUBRID (PDO) � CUBRID Functions (PDO_CUBRID)
MS SQL Server (PDO) � Microsoft SQL Server and Sybase Functions (PDO_DBLIB)
Firebird/Interbase (PDO) � Firebird/Interbase Functions (PDO_FIREBIRD)
IBM (PDO) � IBM Functions (PDO_IBM)
Informix (PDO) � Informix Functions (PDO_INFORMIX)
MySQL (PDO) � MySQL Functions (PDO_MYSQL)
MS SQL Server (PDO) � Microsoft SQL Server Functions (PDO_SQLSRV)
Oracle (PDO) � Oracle Functions (PDO_OCI)
ODBC and DB2 (PDO) � ODBC and DB2 Functions (PDO_ODBC)
PostgreSQL (PDO) � PostgreSQL Functions (PDO_PGSQL)
SQLite (PDO) � SQLite Functions (PDO_SQLITE)
4D (PDO)
* 
*/ 
/**
 * ��������� ������:
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
// �����  SELECT ������ ����������� - �� �������� PDOStatement ������ � �������� ������
// � � ��� �������� ��� ��������� ������:
/**
 *  
    PDOStatement->bindColumn � Bind a column to a PHP variable
 *  Since information about the columns is not always available to PDO until the statement is executed, 
 *  portable applications should call this function after PDOStatement::execute(). 
 * 
    PDOStatement->bindParam � Binds a parameter to the specified variable name
    PDOStatement->bindValue � Binds a value to a parameter
    PDOStatement->closeCursor � Closes the cursor, enabling the statement to be executed again.
    PDOStatement->columnCount � Returns the number of columns in the result set
    PDOStatement->debugDumpParams � Dump an SQL prepared command
    PDOStatement->errorCode � Fetch the SQLSTATE associated with the last operation on the statement handle
    PDOStatement->errorInfo � Fetch extended error information associated with the last operation on the statement handle
    PDOStatement->execute � Executes a prepared statement
    PDOStatement->fetch � Fetches the next row from a result set
    PDOStatement->fetchAll � Returns an array containing all of the result set rows
    PDOStatement->fetchColumn � Returns a single column from the next row of a result set
    PDOStatement->fetchObject � Fetches the next row and returns it as an object.
    PDOStatement->getAttribute � Retrieve a statement attribute
    PDOStatement->getColumnMeta � Returns metadata for a column in a result set
    PDOStatement->nextRowset � Advances to the next rowset in a multi-rowset statement handle
    PDOStatement->rowCount � Returns the number of rows affected by the last SQL statement
    PDOStatement->setAttribute � Set a statement attribute
    PDOStatement->setFetchMode � Set the default fetch mode for this statement
 */
/**
 * �������� �������� ��������� �������:
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