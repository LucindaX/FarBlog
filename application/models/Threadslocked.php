<?php

class Application_Model_Threadslocked extends Zend_Db_Table_Abstract
{
    protected $_name="threads_locked";
    
    
    function lockThread($threadId){
        
      return  $this->insert(array("threads_locked.thread_id" => $threadId));
       
        
    }
    
    function unlockThread($threadId){
        
        return $this->delete("threads_locked.thread_id=$threadId");
    }

}

