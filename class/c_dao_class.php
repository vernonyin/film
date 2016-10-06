<?php

class c_base_dao {

    public $link;

   function __construct() {
        $this->link = mysqli_connect('120.25.78.52:3306', 'vernon', 'vernon');
        if (!$this->link) {
            die('Could not connect to MySQL: ' . mysql_error());
        }
        mysqli_select_db($this->link, "statics");
        mysqli_query($this->link, "set names utf8");
    }

}
