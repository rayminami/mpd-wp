<?php
class statistik_pajak_daerah_controller extends wbController{
    
    public static function tampil() {
        
        try{
            $ws_client = self::getNusoap();
		    $params = array('search' => '',
					'getParams' => json_encode($_GET),
					'controller' => json_encode(array('module' => 'bds','class' => 'statistik_pajak_daerah', 'method' => 'tampil', 'type' => '' )),
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
        $items = $data['items'];
        
        $tahun = wbRequest::getVarClean('tahun', 'int', 0);
        $print = wbRequest::getVarClean('print', 'int', 0);
        if(!empty($print))wbUtil::startExcel('pajak_daerah.xls');
        echo '<div class="body-wrap">';
        echo '<div align="center"><h3>JUMLAH PENERIMAAN PAJAK DAERAH MENURUT JENIS PAJAK DAN PERSENTASE TARGET YANG DICAPAI KOTA BANDUNG </br>TAHUN ANGGARAN '.$tahun.'</h3></div><br>';
        if(!empty($print)){
	        echo '<table border="1" width ="100%">';
	    }else{
	    	echo '<table border="0" width ="100%">';
	    }
        $output = "<tr>";
        $output.= "<th style='text-align:center;background-color: rgb(224, 224, 224);border-bottom: 1px solid black;border-top: 1px solid black;'>NO</th>";
        $output.= "<th style='text-align:center;background-color: rgb(224, 224, 224);border-bottom: 1px solid black;border-top: 1px solid black;'>JENIS PENERIMAAN</br><div style='font-style: italic;'>TYPE OF RECEIPTS</div></th>";
        $output.= "<th style='text-align:center;background-color: rgb(224, 224, 224);border-bottom: 1px solid black;border-top: 1px solid black;'>TARGET</br><div style='font-style: italic;'>TARGET</div>(Rp 000)&nbsp</th>";
        $output.= "<th style='text-align:center;background-color: rgb(224, 224, 224);border-bottom: 1px solid black;border-top: 1px solid black;'>REALISASI</br><div style='font-style: italic;'>REALISATION</div>(Rp 000)&nbsp</th>";
        $output.= "<th style='text-align:center;background-color: rgb(224, 224, 224);border-bottom: 1px solid black;border-top: 1px solid black;'>PERSENTASE</br><div style='font-style: italic;'>PERCENTAGE</div>(%)</th>";
        $output.= "</tr>";
        $title = "";
        $no=1;
        $t_persen=0;
        $t_real=0;
        $t_target=0;
        foreach($items as $item){
        	$output.= "<tr>";
        	$output.= "<td width=50 align=center>".$no."</td>";
        	$output.= "<td>".$item['param_name']."</td>";
        	$output.= "<td align='center'>".number_format($item['pjk_daerah_target'], 0, ',', '.')."</td>";
        	$output.= "<td align='center'>".number_format($item['pjk_daerah_realisasi'], 0, ',', '.')."</td>";
        	$jumlah = (!empty($item['pjk_daerah_target']) ? ($item['pjk_daerah_realisasi']/$item['pjk_daerah_target']*100):0);
        	$output.= "<td align='center'>".number_format($jumlah, 2, ',', '.')."</td>";
        	$output.= "</tr>";
        	$t_persen+=$jumlah;
	        $t_real+=$item['pjk_daerah_realisasi'];
	        $t_target+=$item['pjk_daerah_target'];
        	$no++;
        }
        $output.="</table>";
        echo $output;
        exit;
    }
}
