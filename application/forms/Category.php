<?php

class Application_Form_Category extends Zend_Form
{

    public function init()
    {
       //$this ->setAction("");
        //$this ->setMethod("post");
        $name =  new Zend_Form_Element_Text("name"); 
        $name->addValidator(new Zend_Validate_Alnum());
        $name->setLabel("Name");
        $name ->setAttrib("class", "form-control");
        $nameValue = $name->getValue();
        
        $desc = new Zend_Form_Element_Text("description");
        $desc->addValidator(new Zend_Validate_Alnum());
        $desc->setLabel("Description");
        $desc ->setAttrib("class", "form-control");
        //$descValue = $desc->getValue();
        
        $add =new Zend_Form_Element_Submit("add");
        
        $this->addElements(array($name, $desc, $add));
    }


}

