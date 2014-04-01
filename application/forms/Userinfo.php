<?php

class Application_Form_Userinfo extends Zend_Form
{

    public function init()
    {
         $this->setAttrib('enctype', 'multipart/form-data');
        
        $username = new Zend_Form_Element_Text("username");
        //$username ->setRequired();
        $username ->addValidator(new Zend_Validate_Alnum($allowWhiteSpace = false)); 
        $username ->setAttrib("class", "form-control");
        $username ->setLabel("Username");
        
        $fname = new Zend_Form_Element_Text("fname");
       //$fname ->setRequired();
        $fname ->addValidator(new Zend_Validate_Alpha()); 
        $fname ->setAttrib("class", "form-control");
        $fname ->setLabel("First name");
        
        $lname = new Zend_Form_Element_Text("lname"); 
        //$lname ->setRequired();
        $lname ->addValidator(new Zend_Validate_Alpha()); 
        $lname ->setAttrib("class", "form-control");
        $lname ->setLabel("Last name");
        
        $gender = new Zend_Form_Element_Radio("gender");
        //$gender ->setRequired();
        $gender ->setAttrib("class", "btn btn-primary");
        $gender ->setLabel("Gender");
        $gender ->addMultiOptions(array(
            'm' => 'Male',
            'f' => 'Female'));
        $gender ->setSeparator('<br>');
        
        $email = new Zend_Form_Element_Text("email");
        $email ->addValidator(new Zend_Validate_EmailAddress);
        $email ->setAttrib("class", "form-control");
        $email ->setLabel("Email");
        
        $password = new Zend_Form_Element_Password("password");
        //$password ->setRequired();
        $password ->setAttrib("class", "form-control");
        //$password ->addValidator(new Zend_Validate_StringLength); //put a max length for pw its place is in registeration
        $password ->setLabel("Password");
        

//->setDestination(BASE_PATH . '/data/uploads')
//->setRequired(true);
        
        $image = new Zend_Form_Element_File("image");
        $image ->addValidator(new Zend_Validate_File_IsImage());
        $image ->setLabel("Profile picture");
        //$image ->setAttrib("accept","image/*");
        $image ->setDestination("/var/www/ZendProject/public/images/");
        $image->addValidator('Count', false, 1);
        $image->addValidator('Size', false, 6000000);
        $image->setMaxFileSize(6000000);
        $image->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        
        $button = new Zend_Form_Element_Submit("btnAdd");
        $button ->setLabel("Add");
        
        $this->addElements(array($username, $fname, $lname, $gender, $email, $password, $image, $button));
        
    }


}

