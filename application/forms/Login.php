<?php

class Application_Form_Login extends Zend_Form
{

    public function init()
    {
    
        
        $email = new Zend_Form_Element_Text("username");
        $email->setRequired(true);
        $email->addValidator(new Zend_Validate_Alnum(false));
        $email->setLabel("Username / Email");
        
        $password = new Zend_Form_Element_Password("password");
        $password->setRequired(true);
        $password->setAttrib("id","password");
        $password->addValidator(new Zend_Validate_Alnum(false));
        $password->setLabel("Password");
        
        
        $this->addElements(array($email,$password));
        $this->setAction("");
        $this->setMethod("post");
        
    }


}

