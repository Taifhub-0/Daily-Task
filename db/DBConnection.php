<?php
class DBConnection{
    public static function getConnection(){
        $dbPath = __DIR__ . '/myDB.db';
        $db = new PDO('sqlite:' . $dbPath);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
}
