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
        if ($this->hasParam("doWhat")) {
            $doWhat = $this->getRequest()->getParam("doWhat");
            $categId = $this->getRequest()->getParam("categId");
            if ($doWhat == "selectAll") {
                $categModel = new Application_Model_Category ();
               return $this->_helper->json->sendJson($categModel->selectAllCategs());
            }else if ($doWhat == "delete") {
                $categModel = new Application_Model_Category ();
                return  $categModel->deleteCateg($categId);
                exit;
            }
        }
        else if($this->hasParam("edited")){
            $this->view->edited= $this->getParam("edited")."  successfully  edited";
        }
        else if($this->hasParam("failed")){
            $this->view->failed= "Failed to edit  ".$this->getParam("edited");

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
           $result= $categModel->editCateg($categs, $categId);
           if($result > 0){
            $this->redirect("/category/ajax-job/edited/category");
           }
           else     $this->redirect("/category/ajax-job/failed/category");

        } else {
            
            $categs = $categModel->getCategById($categId);
            $categForm->populate($categs);
            $this->view->cat_id=$categId;
            
        }
     $this->render('add');   
    
    }

    
    
    
}















