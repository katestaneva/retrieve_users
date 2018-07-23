<?php

/* 
 * File: api/get_users.php
 * 
 * PHP: v5.6
 * 
 * Description: exposing endpoint for selecting users
 * 
 * Author: Ekaterina Staneva
 * 
 * Git: https://github.com/katestaneva/users_RESTA_API.git
 */

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  include_once '../core/usersModel.php';
  
  // Instantiate and connect
  $db = new usersModel();
  $users = $db->select();
  
  if($users->rowCount()){
        $users_arr = array();
        $users_arr['data'] = array();
        while($item = $users->fetch(PDO::FETCH_ASSOC)) {
            extract($item);
            array_push($users_arr['data'], $item);
        }
    echo json_encode($users_arr);
  } else {
    echo json_encode(
      array('message' => 'No users were found')
    );
  }