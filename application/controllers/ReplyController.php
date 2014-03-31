<?php

class ReplyController extends Zend_Controller_Action
{
    private $session = null;
    private $userType = null;    
    private $userId = null;
    
    public function init()
    {
        $this->session = new Zend_Session_Namespace("Zend_Auth");
        $authorization = Zend_Auth::getInstance();
        $this->userId = $this->session->storage->id;
        $this->account_type = $this->session->storage->account_type;
        if(!$authorization->hasIdentity()) {
            echo "error";
        }else{
           // $this->redirect("user/add");
        }
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        $this->view->action = "/reply/add";
        $replyForm = new Application_Form_Reply();
        $this->view->form = $replyForm;
        
        if($this->getRequest()->isPost()){
            $body= $this->getParam("body");
            $date = date('Y-m-d H:i:s');

            $threadId = $this->getParam("threadId");
            $userId = $this->userId; 
            
            $replyModel = new Application_Model_Reply();
            $replyModel->addReply($body, $date, $threadId, $userId);
            $this->redirect("/thread/read/threadId/$threadId");
        }
    }

    public function editAction()
    {
        $this->view->action = "/reply/edit";
        $replyForm = new Application_Form_Reply();
        $this->view->form = $replyForm;
        $replyModel = new Application_Model_Reply();
        if ($this->hasParam("replyId")) {
        $replyId = $this->getRequest()->getParam("replyId");
        $threadId= $this->getParam("threadId");
        }
               
        if ($this->getRequest()->isPost()) {
                      
            $body = $this->getParam("body");
            //$date = date('Y-m-d H:i:s');
            $threadId = $this->getParam("threadId");
         
            $userId = $this->userId;  

            $replyData = array(
                'body' => $body               
            );
            $replyModel->editReply($replyData, $replyId);
            $this->redirect("/thread/read/threadId/$threadId");
        } else {
           
            $replyData = $replyModel->getReplyById($replyId);
            $replyForm->populate($replyData);
            $this->view->replyId=$replyId;
            $this->view->threadId=$threadId;
        }
     $this->render('add');    

    }

    public function deleteAction()
    {
               Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);

       if($this->hasParam("replyId")){
            $replyId = $this->getRequest()->getParam("replyId");
            $replyModel = new Application_Model_Reply();
           echo  $replyModel->deleteReply($replyId);
           exit();
      
       }
    }


}







