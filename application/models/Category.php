<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = "categories";
    
    function selectAllCategs(){
        return $this->fetchAll()->toArray();
    }
    
    function deleteCateg($categId){
         $this->delete("categories.id = $categId");
    }
    
    function addCateg($name, $desc){
        $row = $this->createRow(); 
        $row->name = $name; 
        $row->description = $desc; 
        return $row->save();
    }
    
    function editCateg($categData, $categId){
       $this->update($categData, "categories.id = $categId"); 
    }
    
    function getCategById($categId){
        $select = $this->select()->where("categories.id = $categId");
        return $this->fetchRow($select)->toArray();
    }
    
    
     function getCategNames(){
        $select = $this->select()->from($this,array("id","name"));
        return $this->fetchAll($select)->toArray();
        //return $this->fetchAll()->toArray();
    }
    
    


}

