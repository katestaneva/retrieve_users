<?php
/* 
 * File: core/usersModel.php
 * 
 * PHP: v5.6
 * 
 * Description: Users Model class provides CRUD access for the users table
 * 
 * Author: Ekaterina Staneva
 * 
 * Git: git link...
 */
    class UsersModel extends baseModel {
        private $tableName = "users";
        function __construct(){
           parent::__construct("users");
        }
        
        public function select($limit = ""){
            $sql = "SELECT * FROM ".$this->tableName;
            
            if($limit != ""){
                if($limit > 0 && is_int($limit) ){
                    $sql .= " LIMIT :limit";
                    $exec = $this->pdo->prepare($sql);
                    $limit = $this->sanitizeInput($limit);
                    $exec->bindParam(':limit', $limit);
                }else{
                    echo("DB Error: limit variable malformated.");
                    return false;
                }
            }else{
                $exec = $this->pdo->prepare($sql);
            }

            $exec->execute();
            
            //DEBUG
            $exec->debugDumpParams();
            return $exec;
        }
        
        public function selectSingle($id){
            if(!empty($id) && $id > 0 && is_int($id) ){
                $sql = "SELECT  
                u.username as name, 
                u.updated_at as last_modified,
                u.created_at as created
                FROM ".$this->tableName." AS u 
                WHERE u.id = :id";

                $exec = $this->pdo->prepare($sql);
                $id = $this->sanitizeInput($id);
                $exec->bindParam(':id', $id);
                $exec->execute();
                //DEBUG
                $exec->debugDumpParams();

                return $exec;   
            }else{
                echo("DB Error: id variable malformated.");
                return false;
            }
        }
        
        public function selectRange($rangeStart, $rangeEnd){
            if((!empty($rangeStart)  && !empty($rangeEnd)) && 
               ($rangeStart > 0 && $rangeEnd > 0) && 
               (is_int($rangeStart) && is_int($rangeEnd))){
                
                $sql = "SELECT  
                u.username as name, 
                u.updated_at as last_modified,
                u.created_at as created
                FROM ".$this->tableName." AS u
                WHERE id BETWEEN :rangeStart AND :rangeEnd";
                            
                $exec = $this->pdo->prepare($sql);
                $rangeStart = $this->sanitizeInput($rangeStart);
                $rangeEnd = $this->sanitizeInput($rangeEnd);
                $exec->bindParam(':rangeStart', $rangeStart);
                $exec->bindParam(':rangeEnd', $rangeEnd);
                $exec->execute();

                //DEBUG
                $exec->debugDumpParams();

                return $exec;
            }else{
                echo("DB Error: range variable malformated.");
                return false;
            }
        }
        
        public function insert($username){ 
            $currentTime = date("Y-m-d H:i:s");    
            $sql =  
               "INSERT INTO " .$this->tableName. "
                (`id`, `username`, `updated_at`, `created_at`)
                VALUES ('',:username,'',".$currentTime.")";

            $exec = $this->pdo->prepare($sql);
            $username = $this->sanitizeInput($username);
            $exec->bindParam(':username', $username);

            if($exec->execute()) {
                return true;
            }
            
            echo("DB Error: ".$exec->error);
            return false;
        }
        
        public function update($id,$username){
            if(!empty($id) && $id > 0 && is_int($id) ){
                $sql = " UPDATE " .$this->tableName. "
                SET username=:username WHERE id = :id";
                
                $exec = $this->pdo->prepare($sql);
                $id = $this->sanitizeInput($id);
                $username = $this->sanitizeInput($username);
                $exec->bindParam(':id', $id);
                $exec->bindParam(':username', $username);
                
                if($exec->execute()) {
                    return true;
                }
                
                echo("DB Error: ".$exec->error);
                return false;
            }else{
                echo("DB Error: id variable malformated.");
                return false;
            }     
        }
        
        public function delete($id){
            if(!empty($id) && $id > 0 && is_int($id) ){
                $sql = " DELETE FROM " .$this->tableName. "
                   WHERE id = :id";
                $exec = $this->pdo->prepare($sql);
                $id = $this->sanitizeInput($id);
                $exec->bindParam(':id', $id);

                if($exec->execute()) {
                   return true;
                }

                echo("DB Error: ".$exec->error);
                return false;
            }else{
                echo("DB Error: id variable malformated.");
                return false;
            } 
        }
     }
?>
