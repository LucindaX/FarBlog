<?php

class UserController extends Zend_Controller_Action
{

    private $session = null;
    private $accountType = null;    
    private $userId = null;

    public function init()
    {
        
        $this->session = new Zend_Session_Namespace("Zend_Auth");
        $authorization = Zend_Auth::getInstance();
        if(!$authorization->hasIdentity()) {
            echo "error";
        }else{
            if($this->accountType == "admin"){
                $this->redirect("user/admin-tools");               
            }
        }
    }

    public function indexAction()
    {
        $this->forward("/category/ajax-job");
    }

    public function loginAction()
    {
        
      if($this->_request->getParam("error") != null){
  
         $this->view->error= "signup"; 
          
      }  
        
        
      if ($this->getRequest()->isPost()) {

                $username = $this->_request->getParam("username");
                $password = md5($this->_request->getParam("password"));
                $db = Zend_Db_Table::getDefaultAdapter();
                $authAdapter = new Zend_Auth_Adapter_DbTable($db, 'users', 'username', 'password');
                $authAdapter->setIdentity($username);
                $authAdapter->setCredential($password);
                $result = $authAdapter->authenticate();
                
                if ($result->isValid()) {
                    //$this->_helper->FlashMessenger('Successful Login');
                    $auth = Zend_Auth::getInstance();
                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(array('id', 'account_type', 'email')));                   
                    $dbData = $auth->getStorage()->read();
                    $this->accountType = $dbData-> account_type;
                    $this->userId = $dbData->id;
                    $this->view->id = $this->userId;
                    $this->view->acc = $this->accountType;
                    //$this->layout()->id = $userId;
                    //$this->layout()->account_type = $accountType;
                    $this->redirect("/user");
                    
                } else
                    $this->view->error = "login";
            
        }
    }

    public function signupAction()
    {
        
             $username = $this->_request->getParam("username");
            $email =$this->_request->getParam("email");
            
            $validator = new Zend_Validate_Db_NoRecordExists(
                    array(
                        'table' => 'users',
                        'field' => 'username'
                    )
                );
             $validator2 = new  Zend_Validate_Db_NoRecordExists(
                    array(
                        'table' => 'users',
                        'field' => 'email'
                    )
                );
                if ($validator->isValid($username) && $validator2->isValid($email)) {
                      $object = new Application_Model_User();
                      $password = md5($this->_request->getParam("password"));

                      $user = array("username" => $username, "email" => $email, "password" => $password);
                      $object->addUser($user);
                      $this->redirect('/user/login');    
                    
                    
                    
                    
                } else {
                    // username is invalid; print the reason
                     $this->redirect("/user/login/error/signup");
                    }
    }

    public function adminToolsAction()
    {
        if($this->session->storage->account_type != "admin")
            $this->redirect ("/user/index");
    }

    public function userajaxAction()
    {
       $object = new Application_Model_User();
       if($this->hasParam("read")){
       $arr=$object->getUsers();
       return $this->_helper->json->sendJson($arr);
       }
       else if($this->hasParam("delete")){
         $id=$this->_request->getParam("delete");
         $object->deleteUser($id);
         exit;
       }
       else if($this->hasParam("ban")){
            $id=$this->_request->getParam("ban");
            $object->banUser($id);
          exit;
       }
       else if($this->hasParam("unban")){
            $id=$this->_request->getParam("unban");
            $object->unbanUser($id);
            exit;
            
       }
    }

    public function addinfoAction()
    {
         $this->view->action = "/user/addinfo";
        $profileForm = new Application_Form_Userinfo();
        $this->view->form = $profileForm;
       $userId = $this->session->storage->id;
         if($this->getRequest()->isPost()){
            
            $fname = $this->getParam("fname");
            $lname= $this->getParam("lname");
            $gender= $this->getParam("gender");
            $image = $this->getParam("image");
            if ($profileForm->isValid($this->getRequest()->getParams())) {
                if ($profileForm->image->receive()) {
                    $location = $profileForm->image->getFileName();
                }
            } 

            $userData = array(
                'fname' => $fname,
                'lname' => $lname,
                'gender' => $gender,
                'image' => $image
            );
            $userModel = new Application_Model_User();
            $userModel->addInfo($userData, $userId);
         }
    }

    public function editinfoAction()
    {
        $this->view->action = "/user/editinfo";
        $profileForm = new Application_Form_Userinfo();
        $this->view->form = $profileForm;
        $userModel = new Application_Model_User();
        $userId = $this->getParam("userId");
        
        if ($this->getRequest()->isPost()) {
            
         
            $username = $this->getParam("username");
            $fname = $this->getParam("fname");
            $lname = $this->getParam("lname");
            $gender = $this->getParam("gender");
            $email = $this->getParam("email");
            $password = $this->getParam("password");
            $userData = array(
                'username' => $username,
                'fname' => $fname,
                'lname' => $lname,
                'gender' => $gender,
                'email' => $email,
                'password' => $password
               // 'country' => $country
            );
            $userModel->editUserInfo($userData, $userId);
        } else {
            
            $userData = $userModel->getUserById($userId);
            $profileForm->populate($userData);            
        }
     $this->render('addinfo');  
    }

    public function profileAction()
    {
        if($this->hasParam('id')){
            $userModel = new Application_Model_User();
            $userId = $this->_request->getParam('id');
            $userData = $userModel->getUserById($userId);
            $this->view->userData = $userData;
         }
    
    }

    public function logoutAction()
    {
        //Zend_Auth::getInstance()->clearIdentity();
        unset($this->session->storage->id);
        unset($this->session->storage->account_type);
        $this->_redirect('/user/index');  
    }


}




















