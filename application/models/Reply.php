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
        $this->update($replyData, "replies.id = $replyId");
    }
    
    function deleteReply($replyId){
        $this->delete("replies.id = $replyId");
    }
    
    

}

