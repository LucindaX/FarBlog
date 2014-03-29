<?php

class ReplyController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
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
            $threadId = 3; //-------------------------
            $userId = 1;  //--------------------------
            
            $replyModel = new Application_Model_Reply();
            $this->view->reply = $replyModel->addReply($body, $date, $threadId, $userId);
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
        }
               
        if ($this->getRequest()->isPost()) {
                      
            $body = $this->getParam("body");
            $date = date('Y-m-d H:i:s');
            $threadId = 3;
            $userId = 1;  //--------------------------

            $replyData = array(
                'body' => $body,
                'user_id' => $userId,
                'thread_id' => $threadId,
                'date' => $date               
            );
            $replyModel->editReply($replyData, $replyId);
        } else {
           
            $replyData = $replyModel->getReplyById($replyId);
            $replyForm->populate($replyData);
            $this->view->replyId=$replyId;
        }
     $this->render('add');    

    }

    public function deleteAction()
    {
       if($this->hasParam("replyId")){
            $replyId = $this->getRequest()->getParam("replyId"); 
            $replyModel = new Application_Model_Reply();
            $replyModel->deleteReply($replyId);
       }
    }


}







