<?php
/**
 * Created by PhpStorm.
 * User: Robin
 * Date: 2019/4/18 0018
 * Time: 11:18
 */

namespace app\index\controller;


class Phpexcelload
{
    function abcdefgwulisuibianuplod(){
        echo 123;exit();
        $this->display();//显示页面
    }
    function abcdefgwulisuibian(){
        if (!empty($_FILES)) {
            import("@.ORG.UploadFile");
            $config=array(
                'allowExts'=>array('xlsx','xls'),
                'savePath'=>'./Public/upload/',
                'saveRule'=>'time',
            );
            $upload = new UploadFile($config);
            if (!$upload->upload()) {
                $this->error($upload->getErrorMsg());
            } else {
                $info = $upload->getUploadFileInfo();

            }
            vendor("PHPExcel.PHPExcel");
            $file_name=$info[0]['savepath'].$info[0]['savename'];
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数
            for($i=2;$i<=$highestRow;$i++)//这个地方根据需要,一般第一行是名称,所以从第二行开始循环,也可以从第一行开始
            {

                $data['lianjieid'] = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();//数据库字段和excel列相对应
                $data['yaoqingma'] = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();
                $data['dlmima']= $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
                $data['ljdizhi']= $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
                M('jdb')->add($data);//插入数据库

            }
            $this->success('导入成功！');
        }else
        {
            $this->error("请选择上传的文件");
        }


    }

}