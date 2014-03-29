<?php

class Application_Model_Thread extends Zend_Db_Table_Abstract
{

    protected $_name='threads';
    
    function getThreadsPostCount($forum_id){
  
      $sql =  $this ->select()
             ->from('threads',array('count(*) as thread_num'))
             ->where('forum_id = ?', $forum_id);
      $mythreadcount = $this->fetchAll($sql)->toArray();
     
       $sql =  $this ->select()
             ->from('threads as th',array('count(*) as reply_num'))
             ->join('replies as rp','th.id = rp.thread_id',array())
             ->where("th.forum_id=$forum_id");
       $myreplycount = $this->fetchAll($sql)->toArray();
       
       $threads= $mythreadcount[0]['thread_num'];
       $posts =$myreplycount[0]['reply_num'];
       
       return array("threads"=>$threads,"posts"=>$posts);
  
    }
    
    function getThreads($forum_id){
     
         $sql =  $this ->select()
             ->setIntegrityCheck(false)
             ->from('threads as TH',array("TH.id","TH.name","TH.body","TH.date","TH.visits","TH.sticky","TL.thread_id as locked","U.username as startedBy"))
             ->joinLeft('threads_locked as TL','TH.id = TL.thread_id',array())
             ->join("users as U","U.id=TH.user_id",array() )    
             ->where("TH.forum_id=$forum_id")
             ->order("(sticky = 'true')desc , date desc ");
        
     return $this->fetchAll($sql)->toArray();   
        
        
        
    }
    
    
    function getOnePage($forum_id,$page){
        
         $sql =  $this ->select()
             ->setIntegrityCheck(false)
             ->from('threads as TH',array("TH.id","TH.name","TH.body","TH.date","TH.visits","TH.sticky","TL.thread_id as locked","U.username as startedBy"))
             ->joinLeft('threads_locked as TL','TH.id = TL.thread_id',array())
             ->join("users as U","U.id=TH.user_id",array() )    
             ->where("TH.forum_id=$forum_id")
             ->order("(sticky = 'true')desc , date desc ");
         
            $paginator = new Zend_Paginator(
            new Zend_Paginator_Adapter_DbTableSelect($sql)
    );
    $paginator->setItemCountPerPage(4);
    $paginator->setCurrentPageNumber($page);
    return $paginator;
           
        
        
       
        
    }
    
    function getlatestPost($forum_id){
        
     $sql = $this ->select()
             ->setIntegrityCheck(false)
             ->from('threads',array('threads.name as thread_name','threads.date as date','users.username','users.id'))
             ->join('users','threads.user_id=users.id',array())
             ->where("threads.forum_id=$forum_id")
             ->order("date desc")
             ->limit('1');
    return $this->fetchAll($sql)->toArray();
    
        
        
        
    }
    
    function getlatestReply($thread_id){
        
        
        $sql = $this ->select()
             ->setIntegrityCheck(false)
             ->from('threads',array('threads.id as thread_id','replies.date as date','users.username','users.id'))
             ->join('replies','threads.id=replies.thread_id',array())
             ->join('users','replies.user_id=users.id',array())   
             ->where("threads.id=$thread_id")
             ->order("date desc")
             ->limit('1');
    return $this->fetchAll($sql)->toArray(); 
        
        
    }
    
    
       function getThreadById($threadId){
        $select = $this->select()->where("threads.id = $threadId");
        return $this->fetchRow($select)->toArray();
    }
            
    function addThread($title, $body, $date, $forum, $userId){
        $row = $this->createRow(); 
        $row->name = $title; 
        $row->body = $body;
        $row->user_id = $userId;
        $row->forum_id = $forum;
        $row->date = $date;
        
        return $row->save();
    }
    
    function editThread($threadData, $threadId){
        $this->update($threadData, "threads.id = $threadId");
    }
    

}

