<?php

class Application_Model_Forumslocked extends Zend_Db_Table_Abstract
{
  protected  $_name="forums_locked";
  
  function lockforum($id){
      
     return  $this->insert(array("forum_id"=>$id));
      
  }
  function unlockforum($id){
      
     return $this->delete("forum_id = $id"); 
      
  }

}

