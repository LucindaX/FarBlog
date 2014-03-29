<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
 
   
    protected function _initBaseUrl() { 
        $this->bootstrap("frontController"); 
        $front=$this->getResource("frontController"); 
        $request=new Zend_Controller_Request_Http(); 
        $front->setRequest($request); 
    } 

 

}

