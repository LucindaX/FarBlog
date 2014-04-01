<?php

class Application_Model_Reply extends Zend_Db_Table_Abstract
{


     protected $_name = "replies";
    
    function getReplyById($replyId){
        $select = $this->select()->where("replies.id = $replyId");
        return $this->fetchRow($select)->toArray();
    }
            
    function addReply($body, $date, $threadId, $userId){
        $row = $this->createRow(); 
        $row->body = $body;
        $row->user_id = $userId;
        $row->thread_id = $threadId;
        $row->date = $date;
        
        return $row->save();
    }
    
    function editReply($replyData, $replyId){
       return $this->update($replyData, "replies.id = $replyId");
    }
    
    function deleteReply($replyId){
       return $this->delete("replies.id = $replyId");
    }
    
    function getReplies($threadId){
        
          $select = $this->select()
                  ->setIntegrityCheck(false)
                  ->from("replies as Th",array("Th.thread_id","Th.id","Th.body as body","Th.date","users.image","users.username","users.id as user_id","users.date_joined","users.country as location") )
                  ->join("users","Th.user_id=users.id",array())
                  ->where("Th.thread_id=$threadId")
                  ->order("date ASC");
                
        return $this->fetchAll($select)->toArray();
        
    }
    function getReplyCount($threadId){
        
        $select= $this->select()->from("replies",array("count(*) as replycount"))->where("thread_id =$threadId");
        return $this->fetchAll($select)->toArray();
        
        
    }
    
    

}

