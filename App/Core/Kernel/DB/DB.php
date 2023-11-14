<?php


namespace Webazex\App\Core\Kernel\DB;


class DB
{
    private static $creds;
    public static $dbh;

    private static function init()
    {
        $cfg = require_once 'App/cfg.php';
        self::$creds = $cfg['bd'];
    }

    /**
     * @return mixed
     */
    public static function getCreds()
    {
        return self::$creds;
    }

    static public function connect()
    {
        try {
            self::init();
            $creds = self::getCreds();
            $link = 'mysql:host=' . $creds['host'] . ';dbname=' . $creds['db'];
            self::$dbh = new \PDO($link, $creds['user'], $creds['psw']);
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    static public function insert(string $tName, array $data){
        try {
            $dbh = (is_null(self::$dbh))? self::connect() : self::$dbh;
            $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $sql = $dbh->prepare("insert into `$tName` ($columns) values ($placeholders)");
            $i = 0;
            foreach ($data as $item){
                $i++;
                $sql->bindValue($i, $item);
            }
            $sql->execute();
            $dbh->commit();
            self::close();
        } catch (\Exception $e){
            echo $e->getMessage();
        }
    }
    static public function close(){
        self::$dbh = null;
    }

    static public function read(string $tName, array $data){

    }
}