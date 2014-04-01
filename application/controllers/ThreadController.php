<?php

class ThreadController extends Zend_Controller_Action
{

    private $session = null;

    private $userType = null;

    private $userId = null;

    public function init()
    {
        $this->session = new Zend_Session_Namespace("Zend_Auth");
        $authorization = Zend_Auth::getInstance();
        if(isset($this->session->storage->id)){
        $this->userId = $this->session->storage->id;
        $this->account_type = $this->session->storage->account_type;
        }
    }

    public function indexAction()
    {
        
            
            
    }

    public function readAction()
    {
        $model_threads = new Application_Model_Thread();
        $model_replies = new Application_Model_Reply();
         $form_reply =  new Application_Form_Reply();
       
        if($this->hasParam("threadId")){
            if($this->hasParam("page")) $page=$this->getParam ("page");
              else $page=1;
             $threadId=$this->_request->getParam("threadId"); 
           
           
            $thread = $model_threads->getThreadById($threadId);
            $replies = $model_replies->getReplies($threadId);
            //$thread[]=$replies;
           // $arr=array("replies"=>$replies,"thread"=>$thread);
           
            
            $this->view->thread_id = $threadId;
            if(isset($this->session->storage->id))
            $this->view->user_id=$this->session->storage->id;
            
            $paginator = Zend_Paginator::factory($replies);
            $paginator->setItemCountPerPage(4);
            $paginator->setCurrentPageNumber($page);
          
            $this->view->paginator=$paginator;
            $this->view->page=$page;
            $this->view->form=$form_reply;
            
            
            if(isset($this->session->storage->id))
            $this->view->account_type= $this->session->storage->account_type;
             }
             
            if($this->getRequest()->isXmlHttpRequest()){  
                
           if($this->hasParam("thread")){
           return $this->_helper->json->sendJson($thread);
           exit;
            }
            else{
             return $this->_helper->json->sendJson($paginator);
           exit;   
            }
            }
        
            
            
           
            if($this->getRequest()->isGet())
                $model_threads->updateVisits($threadId);
            
               }

    public function listAction()
    {
        // action body
          if($this->hasParam("forum_id")){
              if($this->hasParam("page")) $page=$this->getParam ("page");
              else $page=1;
           $forum_name=$this->getParam("forum_name"); 
           $forum_id=$this->_request->getParam("forum_id"); 
           $database = new Application_Model_Thread();
           $results=$database->getThreads($forum_id);
           $arr=array();
              foreach ($results as $thread){
               $latestreply=$database->getlatestReply($thread["id"]);
               $thread["latestpost"]=$latestreply;
               $arr[]=$thread;
               }
            $paginator = Zend_Paginator::factory($arr);
            $paginator->setItemCountPerPage(3);
            $paginator->setCurrentPageNumber($page);
          // $paginator = $database->getOnePage($forum_id,$page);
            $this->view->paginator=$paginator;
            $this->view->page=$page;
              
          if($this->getRequest()->isXmlHttpRequest()){
              Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
               return $this->_helper->json->sendJson($paginator);
               exit;
          }
           
           else {
               $this->view->forum_id=$forum_id;
               $this->view->forum_name=$forum_name;
               if(isset($this->session->storage->id)){
               $this->view->account_type=$this->session->storage->account_type;
               $this->view->user_id=$this->session->storage->id;
                }
           
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
        $threadModel = new Application_Model_Thread();
        
        if($this->getRequest()->isPost()){
            $title = $this->getParam("name");
            $body= $this->getParam("body");
            $date = date('Y-m-d H:i:s');
            $forum = $this->getParam("forum_id");
            
            
            $checkName = $threadModel->uniqueName($title);
            if($checkName){
                $this->redirect("/thread/add");
            }
            
            $success = $threadModel->addThread($title, $body, $date, $forum, $this->session->storage->id);
            if($success){
                $this -> redirect("/thread/read/threadId/".$success."");
            }else{
                $this -> redirect("/thread/read/threadId/".$success."");
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

            /*$checkName = $threadModel->uniqueName($title);
            if(count($checkName)){
                $this->redirect("/thread/edit"); //---------------
            }*/

            $threadData = array(
                'name' => $title,
                'body' => $body           
            );
            $threadModel->editThread($threadData, $threadId);
            $this->redirect("/thread/list");
        } else {
          
            $threadData = $threadModel->getThreadById($threadId);
            $threadForm->populate($threadData);
            $this->view->threadId=$threadId;
        }
     $this->render('add');    

    }

    public function deleteAction()
    {
               

        if($this->hasParam("threadId")){
            
           $model =  new Application_Model_Thread();
           echo $model->deleteThread($this->getParam("threadId"));
            exit();
        }
    }

    public function lockAction()
    {
       

        if($this->hasParam("threadId")){
            
           $model =  new Application_Model_Threadslocked();
           echo $model->lockThread($this->getParam("threadId"));
            exit();
        }
    }

    public function unlockAction()
    {
            

       if($this->hasParam("threadId")){
            
           $model =  new Application_Model_Threadslocked();
           echo $model->unlockThread($this->getParam("threadId"));
            exit();
        }
    }

    public function stickAction()
    {
         if($this->hasParam("threadId")){
            
           $model =  new Application_Model_Thread();
           echo $model->stickThread($this->getParam("threadId"));
            exit();
        }
    }

    public function unstickAction()
    {
           if($this->hasParam("threadId")){
            
           $model =  new Application_Model_Thread();
           echo $model->unstickThread($this->getParam("threadId"));
            exit();
        }
    }


}





















