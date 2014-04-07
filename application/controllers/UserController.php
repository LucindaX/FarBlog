<?php

class UserController extends Zend_Controller_Action
{

    private $session = null;

    private $accountType = null;

    private $userId = null;

    private $lockSystem = null;

    private $frontController = null;

    public function init()
    {
        $this->lockSystem = Zend_Registry::get('lockSystem');
        //$frontController = Zend_Controller_Front::getInstance();
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
        
     echo $this->getParam("status");
    $url=$this->view->baseUrl();
     $this->redirect("/category/ajax-job");
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
                    $storage->write($authAdapter->getResultRowObject(array('id', 'account_type', 'status')));                   
                    $dbData = $auth->getStorage()->read();
                    $this->accountType = $dbData-> account_type;
                    $this->userId = $dbData->id;
                    $status = $dbData->status;
                    
                    $this->view->id = $this->userId;
                    $this->view->acc = $this->accountType;
                    $this->view->status = $status;
                    
                    if(!strcmp($status,"banned")) {
                        $this->view->error="ban";
                        $storage->clear();
                        ;
                    }
                    
                   else if(!strcmp($status,"online")) {
                        $this->view->error="online";
                        $storage->clear();
                    }
                    
                  
                    
                   else{
                    $user = new Application_Model_User();
                    $changeStatus = array('status' => 'online');
                    $user->changeStatus($changeStatus, $this->userId);
                   }
                    

                    $lockStatus = new Application_Model_LockSystem();
                    $lockSys = $lockStatus->getLockStatus();
                    $this->view->lock = $lockSys;
                  if($lockSys["status"] == "locked" && $this->accountType == "normal"){                      
			$this->redirect("/user/logout");
                    }
                    
                    if( strcmp($status,"banned") && strcmp($status,"online"))
                    $this->redirect("/user/index");
                   
                    
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

                      $user = array("username" => $username, "email" => $email, "password" => $password,"status"=>"online","date_joined"=>date('Y-m-d H:i:s'));
                     $user_id = $object->addUser($user);
                      
                    
                     
                        $auth = Zend_Auth::getInstance();
                        $storage = $auth->getStorage();
                     
                        $this->session->storage->account_type = "normal";
                        $this->session->storage->id = $user_id;
                        $this->userId=$user_id;
                        $this->accountType="normal";
                        
                     
                        
                 /*     
                      $smtpHost = 'smtp.mail.yahoo.com';
                      echo $email;
                    $smtpConf = array(
                        'auth' => 'login',
                        'ssl' => 'ssl',
                        'port' => '465',
                        'username' => '',  
                        'password' => ''
                       );
                    $transport = new Zend_Mail_Transport_Smtp($smtpHost, $smtpConf);
                    $mail   = new Zend_Mail();
                    $mail->setBodyText('Welcome in our Website.. :)');
                    $mail->setFrom('Blend Forums.com');
                    $mail->addTo($email);
                    $mail->setSubject('Confirmation email');
                    $mail->send($transport);
                   */   
                      
                      
                      $this->redirect('/user/index');    
                    
                    
                    
                    
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
       $lockSystem = new Application_Model_LockSystem();
       
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
       }else if ($this->hasParam("lock")) {
           $check = $this->_request->getParam("lock");
           $this->view->check = $check;
           if($check == "true"){
               $status = array('status' => 'locked');
               $lockSystem->lockSystem($status);
           }
           else{
               $status = array('status' => 'unlocked');
               $lockSystem->lockSystem($status);
           }
           exit;
        }
        else if($this->hasParam("account_type")){
            
           $account_type=$this->getParam("account_type");
           $id=$this->getParam("Id");
           
           echo $object->changeAccount($account_type,$id); 
            exit;
            
            
            
        }
    }

    public function addinfoAction()
    {
        $this->view->action = "/user/addinfo";
        $profileForm = new Application_Form_Userinfo();
        $this->view->form = $profileForm;
        $userId = $this->session->storage->id;
        if ($this->getRequest()->isPost()) {
            $fname = $this->getParam("fname");
            $lname = $this->getParam("lname");
            $gender = $this->getParam("gender");
            $image = $this->getParam("image");
            $country = $this->getParam("country");
            
            if ($profileForm->isValid($this->getRequest()->getParams())) {
                if ($profileForm->image->receive()) {
                    $location = $profileForm->image->getFileName();
                    $index =  strpos($location,'images');
                    $image = substr($location,$index-1);
                }
            }

            $userData = array(
                'fname' => $fname,
                'lname' => $lname,
                'gender' => $gender,
                'image' => $image,
                'country'=>$country
            );
            $userModel = new Application_Model_User();
            $userModel->addInfo($userData, $userId);
            $this->redirect("/user/profile");///id/".$userId."");
        }
    }

    public function editinfoAction()
    {
        $this->view->action = "/user/editinfo";
        $profileForm = new Application_Form_Userinfo();
        $this->view->form = $profileForm;
        $userModel = new Application_Model_User();
        $userId = $this->session->storage->id;
        
        if ($this->getRequest()->isPost()) {         
            $username = $this->getParam("username");
            $fname = $this->getParam("fname");
            $lname = $this->getParam("lname");
            $gender = $this->getParam("gender");
            $email = $this->getParam("email");
            $password = $this->getParam("password");
            $image = $this->getParam("image");
            
            if ($profileForm->isValid($this->getRequest()->getParams())) {
                if ($profileForm->image->receive()) {
                    $location = $profileForm->image->getFileName();
                    $index =  strpos($location,'images');
                    $image = substr($location,$index-1);
                }
            }
            $userData = array(
                'username' => $username,
                'fname' => $fname,
                'lname' => $lname,
                'gender' => $gender,
                'email' => $email,
                'password' => $password,
                'image' => $image
               // 'country' => $country
            );
            $userModel->editUserInfo($userData, $userId);
            $this->redirect("/user/profile");///id/".$userId."");
        } else {
            
            $userData = $userModel->getUserById($userId);
            $profileForm->populate($userData);            
        }
     $this->render('addinfo');  
    }

    public function profileAction()
    {

        $userModel = new Application_Model_User();
        if($this->hasParam('id')){         
            $userId = $this->_request->getParam('id');
        }else{
            if(isset($this->session->storage->id)){

            $userId = $this->session->storage->id;
            }
        }
            $userData = $userModel->getUserById($userId);
            $this->view->userData = $userData;
 
    }

    public function logoutAction()
    {
       // Zend_Auth::getInstance()->clearIdentity();
        $user = new Application_Model_User();
        $changeStatus = array('status' => 'offline');
        $user->changeStatus($changeStatus, $this->session->storage->id);
        
        unset($this->session->storage->id);
        unset($this->session->storage->account_type);
        $this->_redirect('/user/index');  
    }

    public function locksystemAction()
    {
        // action body
    }


}






















