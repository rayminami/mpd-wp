<?php
/**
 * bphtb_registration
 * class model for table bds_bphtb_registration 
 *
 * @since 23-10-2012 12:07:20
 * @author hilman farid
 */
class t_cust_account extends AbstractTable{
    /* Table name */
    public $table = 't_cust_account';
    /* Alias for table */
    public $alias = 'settlement';
    /* List of table fields */
    public $fields = array(
                           't_cust_account_id' => array('type' => 'int', 'nullable' => false, 'unique' => true, 'display' => 't_cust_account_id'),
                           'created_by' => array('type' => 'str', 'nullable' => false, 'unique' => false, 'display' => 'created_by'),
                           'created_by' => array('type' => 'date', 'nullable' => true, 'unique' => false, 'display' => 'created_by'),
                           'updated_date' => array('type' => 'date', 'nullable' => true, 'unique' => false, 'display' => 'updated_date'),
                           'updated_by' => array('type' => 'date', 'nullable' => true, 'unique' => false, 'display' => 'updated_by')
                           );
                           
                           
    /* Display fields */
    public $displayFields = array('t_cust_account_id');
    /* Details table */
    public $details = array();
    /* Primary key */
    public $pkey = 't_cust_account_id';
    /* References */    
    public $refs = array();
    
    /* select from clause for getAll and countAll */
    public $selectClause = "select *";

    public $fromClause = "FROM sikp.t_cust_account settlement";

    function __construct(){
        parent::__construct();
   	}
    
    /**
     * validate
     * input record validator
     */
    public function validate(){
        $userInfo = wbUser::getSession();
        
        if ($this->actionType == 'CREATE'){
            // TODO : Write your validation for CREATE here
            $this->record['creation_date'] = date('Y-m-d');
            $this->record['created_by'] = $userInfo['user_name'];
            
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userInfo['user_name'];
            
        }else if ($this->actionType == 'UPDATE'){
            // TODO : Write your validation for UPDATE here
            $this->record['updated_date'] = date('Y-m-d');
            $this->record['updated_by'] = $userInfo['user_name'];
        }
        
        return true;
    }
}
?>