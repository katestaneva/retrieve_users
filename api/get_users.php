<?php

/* 
 * File:
 * 
 * PHP: v5.6
 * 
 * Description:
 * 
 * Author: Ekaterina Staneva
 * 
 * Git: git link...
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