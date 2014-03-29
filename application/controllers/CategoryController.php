<?php

class CategoryController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

   public function ajaxJobAction()
    {
        if ($this->getRequest()->isGet()) {
            $doWhat = $this->getRequest()->getParam("doWhat");
            $categId = $this->getRequest()->getParam("categId");
            if ($doWhat == "selectAll") {
                $categModel = new Application_Model_Category ();
               return $this->_helper->json->sendJson($categModel->selectAllCategs());
            }elseif ($doWhat == "delete") {
                $categModel = new Application_Model_Category ();
                $this->view->categs = $categModel->deleteCateg($categId);
            }
        }
    }

    public function addAction()
    {
        $this->view->action = "/category/add";
        $categForm = new Application_Form_Category();
        $this->view->form = $categForm;
        if($this->getRequest()->isPost()){
            $name = $this->getParam("name");
            $desc= $this->getParam("description");      
            $categModel = new Application_Model_Category();
            $this->view->categs = $categModel->addCateg($name, $desc);
        }
        
    }

    public function editAction()
    {
         $this->view->action = "/category/edit";
        $categForm = new Application_Form_Category();
        $this->view->form = $categForm;
        $categModel = new Application_Model_Category();
        if ($this->hasParam("id")) {
       $categId = $this->getRequest()->getParam("id"); 
        }
               
        if ($this->getRequest()->isPost()) {
            $name = $this->getParam("name");           
            $desc = $this->getParam("description");
            $categId=$this->getParam("id");
            $categs = array(
                'name' => $name,
                'description' => $desc
            );
            $categModel->editCateg($categs, $categId);
        } else {
            
            $categs = $categModel->getCategById($categId);
            $categForm->populate($categs);
            $this->view->cat_id=$categId;
            
        }
     $this->render('add');   
    
    }

    
    
    
}















