<?php

class Application_Model_Forum extends Zend_Db_Table_Abstract
{

    
    protected  $_name="forums";
    
    function getforums($id){
        
      $sql =  $this ->select()
              ->setIntegrityCheck(false)
             ->from('forums as F',array("F.id","F.name","F.id","F.description","FL.forum_id as locked"))
             ->joinLeft('forums_locked as FL','F.id = FL.forum_id',array())
             ->where("F.cat_id=$id");
   
        
     return $this->fetchAll($sql)->toArray();   
        
        
    }
    
    function deleteforum($id){
        
     return $this->delete("id=$id");   
    
    }
    
    function getForumById($forumId){
        $select = $this->select()->where("forums.id = $forumId");
        return $this->fetchRow($select)->toArray();
    }
            
    function addforum($name, $desc, $cat_id){
        $row = $this->createRow(); 
        $row->name = $name; 
        $row->description = $desc;
        $row->cat_id = $cat_id;
        return $row->save();
    }
    
    function editForum($forumData, $forumId){
      return  $this->update($forumData, "forums.id = $forumId");
    }

    function getForumsNames(){
        $select = $this->select()->from($this,array("id","name"));
        return $this->fetchAll($select)->toArray();
        //return $this->fetchAll()->toArray();
    }

    
    
    
    
   
    
    

}

