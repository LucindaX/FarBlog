<?php

class ForumController extends Zend_Controller_Action
{
    private $session;
    private $userId;
    private $account_type;

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

    public function forumajaxAction() {
        //if($this->getRequest()->isXmlHttpRequest())
        Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
        $forummodel = new Application_Model_Forum();
        if ($this->hasParam("read")) {

            $cat_id = $this->_request->getParam("read");
            $threadmodel = new Application_Model_Thread();
            $forumresult = $forummodel->getforums($cat_id);

            $arr = array();
            foreach ($forumresult as $forum) {
                $count = $threadmodel->getThreadsPostCount($forum["id"]);
                $latest = $threadmodel->getlatestPost($forum["id"]);
                $my = array("id" => $forum["id"], "name" => $forum["name"], "locked" => $forum["locked"], "description" => $forum["description"], "threads" => $count["threads"], "posts" => $count["posts"] + $count["threads"], "latestpost" => $latest);
                $arr[] = $my;
            }
            // print_r ($arr);
            return $this->_helper->json->sendJson($arr);
        }
     
     else if($this->hasParam("delete")){
         
      
       $result = $forummodel->deleteforum($this->_request->getParam("delete"));
       echo $result;
       exit;
         
     }
     
     else if($this->hasParam("lock")){
        $table= new Application_Model_Forumslocked();
        $result = $table->lockforum($this->_request->getParam("lock")); 
        echo $result;
        exit; 
     }
     
     else if($this->hasParam("unlock")){
        $table= new Application_Model_Forumslocked();
        $result = $table->unlockforum($this->_request->getParam("unlock")); 
        echo $result;
        exit; 
     }    
         
        
    }

    public function editAction()
    {
        //added or failed notice in admin-tools
         $this->view->action = "/forum/edit";
        $forumForm = new Application_Form_Forum();
        $this->view->form = $forumForm;
        $forumModel = new Application_Model_Forum();
        if ($this->hasParam("forumId")) {
       $forumId = $this->getRequest()->getParam("forumId"); 
        }
               
        if ($this->getRequest()->isPost()) {
            $name = $this->getParam("name");           
            $desc = $this->getParam("description");
            $cat_id = $this->getParam("cat_id");
            $forumId=$this->getParam("id");
            $forumData = array(
                'name' => $name,
                'description' => $desc,
                'cat_id' => $cat_id
            );
            $result= $forumModel->editForum($forumData, $forumId);
              if($result > 0){
            $this->redirect("/category/ajax-job/edited/forum");
           }
           else     $this->redirect("/category/ajax-job/failed/forum");

        } else {
           
            $forumData = $forumModel->getForumById($forumId);
            $forumForm->populate($forumData);
            $this->view->forumId=$forumId;
            
        }
     $this->render('add');    
  
    }

    public function addAction()
    {
         $this->view->action = "/forum/add";
        $forumForm = new Application_Form_Forum();
        $this->view->form = $forumForm;

        if($this->getRequest()->isPost()){
            $name = $this->getParam("name");
            $desc= $this->getParam("description"); 
            $cat_id = $this->getParam("cat_id");
            $forumModel = new Application_Model_Forum();
            $success = $forumModel->addforum($name, $desc, $cat_id); 
            if($success){
                $this -> redirect("/user/admin-tools/status/addedForum/id/".$success."");
            }else{
                $this -> redirect("/user/admin-tools/status/failedForum/id/".$success."");
            }
        }
    }


}







