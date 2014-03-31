<?php

class ThreadController extends Zend_Controller_Action
{
    private $session = null;
    private $userType = null;
    private $userId = null;

    public function init() {
        $this->sessin = new Zend_Session_Namespace("Zend_Auth");
        $authorization = Zend_Auth::getInstance();
        $this->userId = $this->session->storage->id;
        $this->account_type = $this->session->storage->account_type;
        if(!$authorization->hasIdentity()) {
            echo "error";
        }else{
            $this->redirect("thread/list");
        }
    }

    public function indexAction()
    {
        
            
            
    }

    public function readAction()
    {
      
          if($this->hasParam("forum_id")){
            
           $forum_id=$this->_request->getParam("forum_id"); 
           $database = new Application_Model_Thread();
           //$results=$database->getThreads($forum_id);
           $page = $this->_request->getParam('page');
           if (empty($page)) { $page = 1; }
           
            $paginator = $database->getOnePage($forum_id,$page);
            $this->view->paginator = $paginator;
            Zend_Registry::set('pag', $paginator);
            
           $arr=array();
           /*    foreach ($paginator as $thread){
               $latestreply=$database->getlatestReply($thread["id"]);
               $thread["latestpost"]=$latestreply;
               $arr[]=$thread;
               }*/    
           
           
           
          if($this->getRequest()->isXmlHttpRequest()){
              Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
               return $this->_helper->json->sendJson($paginator);
               exit;
          }
           
           else {
               $this->view->forum_id=$forum_id;
           }
            
            
            
          }
           
       
        
        
    }

    public function listAction()
    {
        // action body
          if($this->hasParam("forum_id")){
            
           $forum_id=$this->_request->getParam("forum_id"); 
           $database = new Application_Model_Thread();
           $results=$database->getThreads($forum_id);
           $arr=array();
               foreach ($results as $thread){
               $latestreply=$database->getlatestReply($thread["id"]);
               $thread["latestpost"]=$latestreply;
               $arr[]=$thread;
               }    
          if($this->getRequest()->isXmlHttpRequest()){
              Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
               return $this->_helper->json->sendJson($arr);
               exit;
          }
           
           else {
               $this->view->forum_id=$forum_id;
           }
            
            
            
          }
        
    }

    public function loadPaginatorAction()
    {
         Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
    
    
       echo $this->view->paginationControl(Zend_Registry::get('pag'),
                            'Sliding','my_pagination_control.phtml'); 
    }

    public function addAction()
    {
        $this->view->action = "/thread/add";
        $threadForm = new Application_Form_Thread();
        $this->view->form = $threadForm;
        
        if($this->getRequest()->isPost()){
            $title = $this->getParam("name");
            $body= $this->getParam("body");
            //date_default_timezone_set(date_default_timezone_get());
            $date = date('Y-m-d H:i:s');
            $forum = $this->getParam("forum_id");
  //--------------------------
            
            $threadModel = new Application_Model_Thread();
            //$this->view->thread = $threadModel->addThread($title, $body, $date, $forum, $userId);
            $success = $threadModel->addThread($title, $body, $date, $forum, $this->userId);
            if($success){
                $this -> redirect("/thread/read/status/addedThread/id/".$success."");
            }else{
                $this -> redirect("/thread/read/status/failedThread/id/".$success."");
            }
        }
    }

    public function editAction()
    {
         $this->view->action = "/thread/edit";
        $threadForm = new Application_Form_Thread();
        $this->view->form = $threadForm;
        $threadModel = new Application_Model_Thread();
        if ($this->hasParam("threadId")) {
       $threadId = $this->getRequest()->getParam("threadId"); 
        }
               
        if ($this->getRequest()->isPost()) {
          
            $title = $this->getParam("name");           
            $body = $this->getParam("body");
            $date = date('Y-m-d H:i:s');
            $forum = $this->getParam("forum_id");
            //$userId = 1;  //--------------------------

            $threadData = array(
                'name' => $title,
                'body' => $body,
                'user_id' => $this->userId,
                'forum_id' => $forum,
                'date' => $date               
            );
            $threadModel->editThread($threadData, $threadId);
        } else {
          
            $threadData = $threadModel->getThreadById($threadId);
            $threadForm->populate($threadData);
            $this->view->threadId=$threadId;
        }
     $this->render('add');    

    }


}











