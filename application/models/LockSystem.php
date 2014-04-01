<?php

class Application_Model_LockSystem extends Zend_Db_Table_Abstract
{
    protected $_name='lockSystem';
    
    function lockSystem($status){
        return $this->update($status, "lockSystem.id = 1");
    }
    
    function getLockStatus(){
        $select = $this->select()->where("lockSystem.id = 1");
        return $this->fetchRow($select)->toArray();
    }

}

