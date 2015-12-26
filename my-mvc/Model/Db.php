<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19.09.15
 * Time: 20:13
  */
namespace Model;
class Db
{
    protected static $connection;
    protected static $config;
    /**
     * @return \PDO
     */
    public static function getConnection()
    {
        if (!isset(self::$connection)) {
            $dsn = "mysql:host=" . self::$config['host'] . ';dbname=' . self::$config['dbname'];
            self::$connection = new \PDO($dsn, self::$config['user'], self::$config['pass']);
        }
        return self::$connection;
    }
    public static function setConfig($config)
    {
        self::$config = $config;
    }
}