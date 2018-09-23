<?php
/** 
 * 创建(导出)Excel数据表格 
 * @param  array   $list        要导出的数组格式的数据 
 * @param  string  $filename    导出的Excel表格数据表的文件名 
 * @param  array   $indexKey    $list数组中与Excel表格表头$header中每个项目对应的字段的名字(key值) 
 * 比如: $indexKey与$list数组对应关系如下: 
 *     $indexKey = array('id','username','sex','age'); 
 *     $list = array(array('id'=>1,'username'=>'YQJ','sex'=>'男','age'=>24)); 
 */  
function exportExcel($list,$filename,$indexKey=array()){  
    require_once 'PHPExcel/IOFactory.php';  
    require_once 'PHPExcel.php';  
    require_once 'PHPExcel/Writer/Excel2007.php';  
      
    $header_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M', 'N','O','P','Q','R','S','T','U','V','W','X','Y','Z');  
      
    //$objPHPExcel = new PHPExcel();                        //初始化PHPExcel(),不使用模板  
    $template = '../class/Template.xls';          //使用模板  
    $objPHPExcel = PHPExcel_IOFactory::load($template);     //加载excel文件,设置模板  
      
    $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);  //设置保存版本格式  
      
    //接下来就是写数据到表格里面去  
    $objActSheet = $objPHPExcel->getActiveSheet();  
    $objActSheet->setCellValue('J2',date('Y-m-d H:i:s'));  
    $i = 4;  
    foreach ($list as $row) {  
        foreach ($indexKey as $key => $value){  
            //这里是设置单元格的内容  
            $objActSheet->setCellValue($header_arr[$key].$i,$row[$value]);  
        }  
        $i++;  
    }  
      
    // 1.保存至本地Excel表格  
    //$objWriter->save($filename.'.xls');  
      
    // 2.接下来当然是下载这个表格了，在浏览器输出就好了  
    header("Pragma: public");  
    header("Expires: 0");  
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");  
    header("Content-Type:application/force-download");  
    header("Content-Type:application/vnd.ms-execl");  
    header("Content-Type:application/octet-stream");  
    header("Content-Type:application/download");;  
    header('Content-Disposition:attachment;filename="'.$filename.'.xls"');  
    header("Content-Transfer-Encoding:binary");
    $objWriter->save('php://output');  
} 
/*
** 数据导出示例
** 2018-02-21
$list = Array
(
	0 => Array(
            'id' => '1',
             'floor'=>'A1'
            'room' => 'A1-12312',
            'type' => '插座,下水道堵塞',
            'desc' => '165465',
			'access' => '是',
            'tel' => '12154545',
            'RepairPerson' => '16415',
            'state' => '001',
            'SubmitTime' => '0000-00-00 00:00:00',
        ),

    1 => Array(
            'id' => '2',
             'floor'=>'A1'
            'room' => 'A1-12312',
            'type' => '插座,下水道堵塞',
            'desc' => '165465',
			'access' => '是',
            'tel' => '12154545',
            'RepairPerson' => '1224',
            'state' => '001',
            'SubmitTime' => '0000-00-00 00:00:00',
        ),

    2 => Array(
            'id' => '3',
            'floor'=>'A1'
            'room' => 'A1-460',
            'type' => '漏水,门插销',
            'desc' => '测试',
			'access' => '是',
            'tel' => '15285155164',
            'RepairPerson' => '001',
            'state' => '001',
            'SubmitTime' => '0000-00-00 00:00:00',
        )

);

exportExcel($list,"1",array('id','floor','room','type','desc','tel','RepairPerson','SubmitTime'));
*/
?>