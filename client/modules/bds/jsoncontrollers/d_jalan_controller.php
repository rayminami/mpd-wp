<?php
/**
 * d_jalan
 * class controller for table bds_d_jalan 
 *
 * @since 23-10-2012 12:07:20
 * @author wiliamdecosta@gmail.com
 */
class d_jalan_controller extends wbController{    
    /**
     * read
     * controler for get all items
     */
    public static function read($args = array()){
        // Security check
        //if (!wbSecurity::check('DJalan')) return;
        
        // Get arguments from argument array
        //extract($args);
        $data = array('items' => array(), 'total' => 0, 'success' => false, 'message' => '');

        try{
            $ws_client = self::getNusoap();
        
		    $params = array('search' => '',
					'getParams' => json_encode($_GET),
					'controller' => json_encode(array('module' => 'bds','class' => 'd_jalan', 'method' => 'read', 'type' => 'json' )),
					'postParams' => json_encode($_POST),
					'jsonItems' => '',
					'start' => $start,
					'limit' => $limit);
					
            $ws_data = self::getResultData($ws_client, $params);
            
            $data['items'] = $ws_data ['data'];
            $data['total'] = $ws_data ['total'];
            $data['message'] = $ws_data ['message'];
            $data['success'] = $ws_data ['success'];
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }
        return $data;
    }

    /**
     * create
     * controler for create new item
     */    
    public static function create($args = array()){
        // Security check
        //if (!wbSecurity::check('DJalan')) return;

        // Get arguments from argument array
        //extract($args);
        $jsonItems = wbRequest::getVarClean('items', 'str', '');
        $items =& wbUtil::jsonDecode($jsonItems);

        $data = array('items' => array(), 'total' => 0, 'success' => false, 'message' => '');

        try{
            $ws_client = self::getNusoap();
		    $params = array('search' => '',
		    			'getParams' => json_encode($_GET),
		    			'controller' => json_encode(array('module' => 'bds','class' => 'd_jalan', 'method' => 'create', 'type' => 'json' )),
		    			'postParams' => json_encode($_POST),
		    			'jsonItems' => '',
		    			'start' => $start,
		    			'limit' => $limit);
            $ws_data = self::getResultData($ws_client, $params);
        
            $data['items'] = $ws_data ['data'];
            $data['total'] = $ws_data ['total'];
            $data['message'] = $ws_data ['message'];
            $data['success'] = $ws_data ['success'];
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    /**
     * update
     * controler for update item
     */        
    public static function update($args = array()){
        // Security check
        //if (!wbSecurity::check('DJalan')) return;
        
        // Get arguments from argument array
        //extract($args);
        $jsonItems = wbRequest::getVarClean('items', 'str', '');
        $items =& wbUtil::jsonDecode($jsonItems);
        
        $data = array('items' => array(), 'total' => 0, 'success' => false, 'message' => '');
        
        try{
            $ws_client = self::getNusoap();
		    $params = array('search' => '',
		    			'getParams' => json_encode($_GET),
		    			'controller' => json_encode(array('module' => 'bds','class' => 'd_jalan', 'method' => 'update', 'type' => 'json' )),
		    			'postParams' => json_encode($_POST),
		    			'jsonItems' => '',
		    			'start' => $start,
		    			'limit' => $limit);
            $ws_data = self::getResultData($ws_client, $params);
                    
            $data['items'] = $ws_data ['data'];
            $data['total'] = $ws_data ['total'];
            $data['message'] = $ws_data ['message'];
            $data['success'] = $ws_data ['success'];
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }

        return $data;
    }

    /**
     * update
     * controler for remove item
     */            
    public static function destroy($args = array()){
        // Security check
        //if (!wbSecurity::check('DJalan')) return;
        
        // Get arguments from argument array
        //extract($args);
        $jsonItems = wbRequest::getVarClean('items', 'str', '');
        $items =& wbUtil::jsonDecode($jsonItems);
        
        $data = array('items' => array(), 'total' => 0, 'success' => false, 'message' => '');

        try{
            $ws_client = self::getNusoap();
		    $params = array('search' => '',
		    			'getParams' => json_encode($_GET),
		    			'controller' => json_encode(array('module' => 'bds','class' => 'd_jalan', 'method' => 'destroy', 'type' => 'json')),
		    			'postParams' => json_encode($_POST),
		    			'jsonItems' => '',
		    			'start' => $start,
		    			'limit' => $limit);
            $ws_data = self::getResultData($ws_client, $params);
        
            $data['items'] = $ws_data ['data'];
            $data['total'] = $ws_data ['total'];
            $data['message'] = $ws_data ['message'];
            $data['success'] = $ws_data ['success'];
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
        }
        return $data;
    }
}
?>