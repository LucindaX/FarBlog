<?php

class Application_Form_Thread extends Zend_Form
{

    public function init()
    {
         $title =  new Zend_Form_Element_Text("name"); 
        $title ->addValidator(new Zend_Validate_Alnum);
        $title ->setLabel("Title");
        $title ->setAttrib("id", "name");
        
        $body = new Zend_Form_Element_Textarea("body");
        $body ->addValidator(new Zend_Validate_Alnum);
        $body ->setLabel("Body");
        $body ->setAttrib("id", "body");

        $forum = new Zend_Form_Element_Select("forum_id");
        $forum ->setLabel("Forum");
        $forum ->setAttrib("id", "forum");
        $forumModel = new Application_Model_Forum();
        $forums = $forumModel->getForumsNames();
        foreach ($forums as $forumName) {
            $forum->addMultiOption($forumName['id'], $forumName['name']);
        }
        $forum ->setAttrib('style', 'width: 175px;');
        
        $add =new Zend_Form_Element_Button("add");
        //$add ->setAttrib('onclick', 'ajaxAdd();');
        $add ->setLabel("Add");
        
        $addEdit =new Zend_Form_Element_Button("edit");
        //$addEdit ->setAttrib('onclick', 'ajaxEdit();');
        $addEdit ->setLabel("Edit");
        
        $this->addElements(array($title, $body, $forum, $add, $addEdit));
    }


}

