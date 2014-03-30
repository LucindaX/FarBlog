<?php

class Application_Model_User extends Zend_Db_Table_Abstract
{

 protected $_name='users';
    
    function addUser($arr){
     
     $this->insert($arr);
    
    }
    
    function getUsers(){
        
    return  $this->fetchAll()->toArray();   
        
    }
    
    function deleteUser($id){
        
      return $this->delete("id=$id");
      
    }
    
     function addInfo($userData, $userId){
        return $this->update($userData, "users.id = $userId");
    } 
    
    function editUserInfo($userData, $userId){
       return $this->update($userData, "users.id = $userId");
    }
    
    function getUserById($userId){
        $select = $this->select()->where("users.id = $userId");
        return $this->fetchRow($select)->toArray();
    }
    
    function banUser($userId){
        return $this->update(array("status"=>"banned"),"id=$userId");
    }
    
    function unbanUser($userId){
        return $this->update(array("status"=>"offline"),"id=$userId");
    }

}

