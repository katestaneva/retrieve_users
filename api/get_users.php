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
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  
  //no AUTH yet..
  
  include_once '../core/usersModel.php';
  
  $db = new usersModel();
  if (isset($_GET["limit"])){
    $users = $db->select($_GET["limit"]);
  }elseif(isset($_GET["startRange"]) && isset($_GET["endRange"])){
    $users = $db->selectRange($_GET["startRange"], $_GET["endRange"]);  
  }else{
    $users = $db->select();
  }
  
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