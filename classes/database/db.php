<?php

class Db {

    protected function connect() {
        try {
            $username = "root";
            $password = "";
            $dbh = new PDO('mysql:host=localhost;dbname=farmshop', $username, $password);

            /*$username = "id20494783_root";
            $password = "(*5l+Pv(_!b8G2EX";
            $dbh = new PDO('mysql:host=localhost;dbname=id20494783_farmshop', $username, $password);*/

            return $dbh;
        } 
        catch (PDOException $e) {
            print "Error: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}