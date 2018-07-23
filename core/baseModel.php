<?php

    /* 
     * File: core/baseModel.php
     * 
     * PHP: v5.6  
     * 
     * Description:  database access asbstract base class. 
     * PDO db connection; CRUD; data sanitization
     * 
     * Author: Ekaterina Staneva
     * 
     * Git:  https://github.com/katestaneva/users_RESTA_API.git
     */

    include ("connect.php");
    include("helper.php");
    
    abstract class baseModel{
        protected $pdo;
        function __construct($db){
            $host = DB_HOST;
            $user = DB_USERNAME;
            $pass = DB_PASSWORD;
            $charset = DB_CHARSET;
           
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

           try { 
                $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);
            }
            catch (PDOException $e) {
               die('Error: '.$e->getMessage().' Code: '.$e->getCode());
            }
        }
        
        abstract protected function select();
        abstract protected function insert($data);
        abstract protected function update($id, $data);
        abstract protected function delete($id);
        
        protected function sanitizeInput($input){
            if(!empty($input)){
               return Helper::sanitize($input);
            }
        }
     }


