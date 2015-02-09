<?php
/**
 * sma
 * class controller for table bds_sma 
 *
 * @since 29-11-2013 07:44:19
 * @author agung.hp
 */
class sma_controller extends wbController{    
    /**
     * read
     * controler for get all items
     */
    public static function read($args = array()){
        // Security check
        //if (!wbSecurity::check('Sd')) return;
        
        // Get arguments from argument array
        //extract($args);
    
        $data = array('items' => array(), 'total' => 0, 'success' => false, 'message' => '');

        try{
            $ws_client = self::getNusoap();
        
		    $params = array('search' => '',
					'getParams' => json_encode($_GET),
					'controller' => json_encode(array('module' => 'bds','class' => 'sma', 'method' => 'read', 'type' => 'json' )),
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
        //if (!wbSecurity::check('Sd')) return;

        // Get arguments from argument array
        //extract($args);
        
        $jsonItems = wbRequest::getVarClean('items', 'str', '');
        $items =& wbUtil::jsonDecode($jsonItems);

        $data = array('items' => array(), 'total' => 0, 'success' => false, 'message' => '');

        try{
            $ws_client = self::getNusoap();
		    $params = array('search' => '',
		    			'getParams' => json_encode($_GET),
		    			'controller' => json_encode(array('module' => 'bds','class' => 'sma', 'method' => 'create', 'type' => 'json' )),
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
        //if (!wbSecurity::check('Sd')) return;
        
        // Get arguments from argument array
        //extract($args);
        $jsonItems = wbRequest::getVarClean('items', 'str', '');
        $items =& wbUtil::jsonDecode($jsonItems);
        
        $data = array('items' => array(), 'total' => 0, 'success' => false, 'message' => '');
        
        try{
            $ws_client = self::getNusoap();
		    $params = array('search' => '',
		    			'getParams' => json_encode($_GET),
		    			'controller' => json_encode(array('module' => 'bds','class' => 'sma', 'method' => 'update', 'type' => 'json' )),
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
        //if (!wbSecurity::check('Sd')) return;
        
        // Get arguments from argument array
        //extract($args);
    
        $jsonItems = wbRequest::getVarClean('items', 'str', '');
        $items =& wbUtil::jsonDecode($jsonItems);
        
        $data = array('items' => array(), 'total' => 0, 'success' => false, 'message' => '');

        try{
            $ws_client = self::getNusoap();
		    $params = array('search' => '',
		    			'getParams' => json_encode($_GET),
		    			'controller' => json_encode(array('module' => 'bds','class' => 'sma', 'method' => 'destroy', 'type' => 'json')),
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
    
    public static function upload_excel($args = array()){
        
        include('lib/excel/reader.php');
        $data = array('items' => array(), 'total' => 0, 'success' => false, 'message' => '');
        
        global $_FILES;
        try {
            if(empty($_FILES['excel_file']['name'])){
                throw new Exception('File tidak boleh kosong');        
            }
        }catch (Exception $e) {
            $data['message'] = $e->getMessage();
            echo json_encode($data);
            session_write_close();
            exit;
        }
        
        $jsonItems = wbRequest::getVarClean('items', 'str', '');
        $sma_tahun_ajaran = wbRequest::getVarClean('sma_tahun_ajaran', 'str', '');
        
        $items =& wbUtil::jsonDecode($jsonItems);
        
        
        if (!is_array($items)){
            $data['message'] = 'Invalid items parameter';
            return $data;
        }
        
        $file_name = $_FILES['excel_file']['name'];
        $file_location = 'var/uploadexcel/'.$file_name;
       
        if (!move_uploaded_file($_FILES['excel_file']['tmp_name'], $file_location)){
            throw new Exception("Upload file gagal");
        }
        
        $xl_reader =& new Spreadsheet_Excel_Reader();
		$res = $xl_reader->_ole->read($file_location);
        
        if($res === false) {
        	if($xl_reader->_ole->error == 1) {
        		$data['message'] = 'Harus File Excel';
                echo json_encode($data);
                session_write_close();
                exit;
        	}
        }
        
        try{
	         $xl_reader->read($file_location);
             $firstColumn = $xl_reader->sheets[0]['cells'][1][1];
             
             if(strtoupper($firstColumn) != 'DATA SEKOLAH MENENGAH') {
                 throw new Exception('Format Table Salah');
             }
                          
               
        } catch(Exception $e) {
                $data['message'] = $e->getMessage();
                echo json_encode($data);
                session_write_close();
                exit;
        }     
             
             /* insert data */
        $recInsert = array();
        
        $items = array();
        try {
           
           //-----------------------
           // SMA
           //-----------------------
           $items[0]['sma_id'] = 1;
           $items[0]['sma_det_thn_ajaran'] = $sma_tahun_ajaran;
           $items[0]['sma_det_jmlsekolah'] = $xl_reader->sheets[0]['cells'][6][3];
           $items[0]['sma_det_siswabaru'] = $xl_reader->sheets[0]['cells'][7][3];
           
           $items[0]['sma_det_siswa_lt_16_thn'] = $xl_reader->sheets[0]['cells'][9][3];
           $items[0]['sma_det_siswa_16_18_thn'] = $xl_reader->sheets[0]['cells'][10][3];
           $items[0]['sma_det_siswa_gt_18_thn'] = $xl_reader->sheets[0]['cells'][11][3];
           
           $items[0]['sma_det_siswa_laki'] = $xl_reader->sheets[0]['cells'][13][3];
           $items[0]['sma_det_siswa_perempuan'] = $xl_reader->sheets[0]['cells'][17][3];
           
           $items[0]['sma_det_jml_siswa_negeri'] = $xl_reader->sheets[0]['cells'][22][3];
           $items[0]['sma_det_jml_siswa_swasta'] = $xl_reader->sheets[0]['cells'][23][3];
           
           $items[0]['sma_det_jml_kelas10'] = $xl_reader->sheets[0]['cells'][25][3];
           $items[0]['sma_det_jml_kelas11'] = $xl_reader->sheets[0]['cells'][26][3];
           $items[0]['sma_det_jml_kelas12'] = $xl_reader->sheets[0]['cells'][27][3];
           
           $items[0]['sma_det_ulang_kelas10'] = $xl_reader->sheets[0]['cells'][33][3];
           $items[0]['sma_det_ulang_kelas11'] = $xl_reader->sheets[0]['cells'][34][3];
           $items[0]['sma_det_ulang_kelas12'] = $xl_reader->sheets[0]['cells'][35][3];
           
           $items[0]['sma_det_putus_kelas10'] = $xl_reader->sheets[0]['cells'][37][3];
           $items[0]['sma_det_putus_kelas11'] = $xl_reader->sheets[0]['cells'][38][3];
           $items[0]['sma_det_putus_kelas12'] = $xl_reader->sheets[0]['cells'][39][3];
           
           
           //------------------------
           // SMK
           //------------------------
           $items[1]['sma_id'] = 2;
           $items[1]['sma_det_thn_ajaran'] = $sma_tahun_ajaran;
           $items[1]['sma_det_jmlsekolah'] = $xl_reader->sheets[0]['cells'][6][4];
           $items[1]['sma_det_siswabaru'] = $xl_reader->sheets[0]['cells'][7][4];
           
           $items[1]['sma_det_siswa_lt_16_thn'] = $xl_reader->sheets[0]['cells'][9][4];
           $items[1]['sma_det_siswa_16_18_thn'] = $xl_reader->sheets[0]['cells'][10][4];
           $items[1]['sma_det_siswa_gt_18_thn'] = $xl_reader->sheets[0]['cells'][11][4];
           
           $items[1]['sma_det_siswa_laki'] = $xl_reader->sheets[0]['cells'][13][4];
           $items[1]['sma_det_siswa_perempuan'] = $xl_reader->sheets[0]['cells'][17][4];
           
           $items[1]['sma_det_jml_siswa_negeri'] = $xl_reader->sheets[0]['cells'][22][4];
           $items[1]['sma_det_jml_siswa_swasta'] = $xl_reader->sheets[0]['cells'][23][4];
           
           $items[1]['sma_det_jml_kelas10'] = $xl_reader->sheets[0]['cells'][25][4];
           $items[1]['sma_det_jml_kelas11'] = $xl_reader->sheets[0]['cells'][26][4];
           $items[1]['sma_det_jml_kelas12'] = $xl_reader->sheets[0]['cells'][27][4];
           
           $items[1]['sma_det_ulang_kelas10'] = $xl_reader->sheets[0]['cells'][33][4];
           $items[1]['sma_det_ulang_kelas11'] = $xl_reader->sheets[0]['cells'][34][4];
           $items[1]['sma_det_ulang_kelas12'] = $xl_reader->sheets[0]['cells'][35][4];
           
           $items[1]['sma_det_putus_kelas10'] = $xl_reader->sheets[0]['cells'][37][4];
           $items[1]['sma_det_putus_kelas11'] = $xl_reader->sheets[0]['cells'][38][4];
           $items[1]['sma_det_putus_kelas12'] = $xl_reader->sheets[0]['cells'][39][4];
           
           //------------------------
           // MA
           //------------------------
           $items[2]['sma_id'] = 3;
           $items[2]['sma_det_thn_ajaran'] = $sma_tahun_ajaran;
           $items[2]['sma_det_jmlsekolah'] = $xl_reader->sheets[0]['cells'][6][5];
           $items[2]['sma_det_siswabaru'] = $xl_reader->sheets[0]['cells'][7][5];
           
           $items[2]['sma_det_siswa_lt_16_thn'] = $xl_reader->sheets[0]['cells'][9][5];
           $items[2]['sma_det_siswa_16_18_thn'] = $xl_reader->sheets[0]['cells'][10][5];
           $items[2]['sma_det_siswa_gt_18_thn'] = $xl_reader->sheets[0]['cells'][11][5];
           
           $items[2]['sma_det_siswa_laki'] = $xl_reader->sheets[0]['cells'][13][5];
           $items[2]['sma_det_siswa_perempuan'] = $xl_reader->sheets[0]['cells'][17][5];
           
           $items[2]['sma_det_jml_siswa_negeri'] = $xl_reader->sheets[0]['cells'][22][5];
           $items[2]['sma_det_jml_siswa_swasta'] = $xl_reader->sheets[0]['cells'][23][5];
           
           $items[2]['sma_det_jml_kelas10'] = $xl_reader->sheets[0]['cells'][25][5];
           $items[2]['sma_det_jml_kelas11'] = $xl_reader->sheets[0]['cells'][26][5];
           $items[2]['sma_det_jml_kelas12'] = $xl_reader->sheets[0]['cells'][27][5];
           
           $items[2]['sma_det_ulang_kelas10'] = $xl_reader->sheets[0]['cells'][33][5];
           $items[2]['sma_det_ulang_kelas11'] = $xl_reader->sheets[0]['cells'][34][5];
           $items[2]['sma_det_ulang_kelas12'] = $xl_reader->sheets[0]['cells'][35][5];
           
           $items[2]['sma_det_putus_kelas10'] = $xl_reader->sheets[0]['cells'][37][5];
           $items[2]['sma_det_putus_kelas11'] = $xl_reader->sheets[0]['cells'][38][5];
           $items[2]['sma_det_putus_kelas12'] = $xl_reader->sheets[0]['cells'][39][5];
           
                           
           $ws_client = self::getNusoap();
		   $params = array('search' => '',
					'controller' => json_encode(array('module' => 'bds','class' => 'sma', 'method' => 'upload_excel', 'type' => 'json' )),
					'jsonItems' => json_encode(array('items' => $items))
					);
								
           $ws_data = self::getResultData($ws_client, $params);
           
           if(!empty($ws_data['message'])) {
              throw new Exception($ws_data['message']);
           }
           
                                 
           $data['success'] = true;
    	   $data['message'] = 'Data berhasil disimpan';
           $data['items'] = $items;
           
        }catch(Exception $e) {
           $data['message'] = $e->getMessage();
           echo json_encode($data);
           session_write_close();
           exit;
        }
	   
	   echo json_encode($data);
       session_write_close();
       exit;
        
    } 
}
?>