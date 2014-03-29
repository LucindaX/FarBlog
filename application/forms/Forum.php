<?php

class Application_Form_Forum extends Zend_Form
{

    public function init()
    {
        $name =  new Zend_Form_Element_Text("name"); 
        $name->addValidator(new Zend_Validate_Alnum());
        $name->setLabel("Name");
        $name ->setAttrib("class", "form-control");
        
        $desc = new Zend_Form_Element_Text("description");
        $desc->addValidator(new Zend_Validate_Alnum());
        $desc->setLabel("Description");
        $desc ->setAttrib("class", "form-control");
        
        $categ = new Zend_Form_Element_Select("cat_id");
        $categ ->setLabel("Category");
        $categModel = new Application_Model_Category();
        $categs = $categModel->getCategNames();
        //$categ ->addMultiOptions($categs);
        foreach ($categs as $categName) {
            $categ->addMultiOption($categName['id'], $categName['name']);
        }
        $categ ->setAttrib('style', 'width: 175px;');
        
        $add =new Zend_Form_Element_Submit("add");
        
        $this->addElements(array($name, $desc, $categ, $add));
    }


}

