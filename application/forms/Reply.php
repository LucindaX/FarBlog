<?php

class Application_Form_Reply extends Zend_Form
{

    public function init()
    {
        $body = new Zend_Form_Element_Textarea("body");
        $body->addValidator(new Zend_Validate_Alnum);
        $body->setLabel("Reply");
        
        $add =new Zend_Form_Element_Submit("add");
        
        $this->addElements(array($body, $add));
    }


}

