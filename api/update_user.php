<?php

/* 
 * File: api/update_user.php
 * 
 * PHP: v5.6
 * 
 * Description: exposing endpoint for updating a single user
 * 
 * Author: Ekaterina Staneva
 * 
 * Git: https://github.com/katestaneva/users_RESTA_API.git
 */
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  
include_once '../core/usersModel.php';

$db = new usersModel();
$post_data = json_decode(file_get_contents("php://input"),true);
$id = $post_data['id'];
$username = $post_data['username'];

if($db->update($id, $username)){
    echo json_encode(
      array('message' => 'User with id '.$id.' was succesfully updated.')
    );
}else{
     echo json_encode(
      array('message' => 'Error. User was not updated.')
    );
    http_response_code(401);
}