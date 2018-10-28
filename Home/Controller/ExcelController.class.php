<?php
namespace Home\Controller;
use Think\Controller;

class ExcelController extends Controller {

	public function writeexcel($ext='.xls',$title='user',$_index=0){
		import('PHPExcel','./Phpexcel','.php');
		$PHPExcel = new \PHPExcel();
		
		//工作表设置
		$PHPExcel -> setActiveSheetIndex($_index);
		$objActSheet = $PHPExcel -> getActiveSheet();
		
		//给当前活动的表设置名称
		$objActSheet -> setTitle($title);
		
		$user = D('user');
		if(session('gids')!=='1'){
			$map['cid'] = session('cid');
		}
		$data = $user -> relation('tel') -> where($map) -> select();

		for($row=0;$row<count($data);$row++){
			if(count($data[$row])<=26){	//小于等于26列的输入方式
				if($row==0){	//设置表格第一行标题
					$col = 1;
					foreach($data[$row] as $key=>$td){
						$objActSheet->setCellValue(chr(64+$col).($row+1),$key);
						$col++;
					}
				}
				
				$col = 1;
				foreach($data[$row] as $key=>$td){
					$objActSheet->setCellValue(chr(64+$col).($row+2),str_replace('.','',$td));
					$col++;
				}
			}else{	//大于26列的输入方式
				if($row==0){	//设置表格第一行标题
					header("Content-type:application/vnd.ms-excel");
					header ('Content-Disposition:attachment;filename=hp.xls' );
					echo '<table>';
					echo '<thead>';
					echo '<tr>';
					foreach($data[$row] as $key=>$td){
						echo '<th>'.$key.'</th>';
					}
					echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
				}
				
				echo '<tr>';
				foreach($data[$row] as $key=>$td){
					echo '<td>'.str_replace('.','',$td).'</td>';
				}
				echo '</tr>';
				
				if($row==(count($data)-1)){
					echo '</tbody>';
					echo '</table>';
					exit;
				}
			}
		}
		
		switch($ext){
			case '.xls':
				import('Excel5','./Phpexcel/PHPExcel/Writer','.php');
				$PHPWriter=new \PHPExcel_Writer_Excel5($PHPExcel);
				$outputFileName = $title.'-'.time().$ext;
				break;
			case 'xlsx':
				import('Excel2007','./Phpexcel/PHPExcel/Writer','.php');
				$PHPWriter=new \PHPExcel_Writer_Excel2007($PHPExcel);
				$outputFileName = $title.'-'.time().'.'.$ext;
				break;
			default:
				echo '<script>alert("参数错误！");history.back();</script>';
				exit;
				break;
		}

		header ( 'Pragma:public');
		header ( 'Expires:0');
		header ( 'Cache-Control:must-revalidate,post-check=0,pre-check=0');
		header ( 'Content-Type:application/force-download');
		header ( 'Content-Type:application/vnd.ms-excel');
		header ( 'Content-Type:application/octet-stream');
		header ( 'Content-Type:application/download');
		header ( 'Content-Disposition:attachment;filename='. $outputFileName );
		header ( 'Content-Transfer-Encoding:binary');
		$PHPWriter->save ( 'php://output');
	}

	public function readexcel(){
		if(!IS_POST){
			$this -> display();
		}else{
			//判断excel后缀
			switch(substr($_FILES['excel']['name'],-4)){
			case '.xls':
				import('Excel5','./Phpexcel/PHPExcel/Reader','.php');
				$PHPReader = new \PHPExcel_Reader_Excel5();
				break;
			case 'xlsx':
				import('Excel2007','./Phpexcel/PHPExcel/Reader','.php');
				$PHPReader = new \PHPExcel_Reader_Excel2007();
				break;
			default:
				echo '<script>alert("文件格式错误！");history.back();</script>';
				exit;
				break;
			}
			
			//读取excel内容到数组
			$filename = $_FILES['excel']['tmp_name'];
			$PHPExcel = $PHPReader -> load($filename);
			$dataArray = $PHPExcel -> getActiveSheet()->toArray(); 
			
			//创建数据模型
			$data = array();
			for($row=1;$row<count($dataArray);$row++){
				$data[$row-1]['realname'] = trim($dataArray[$row][0]);
				$data[$row-1]['card'] = trim($dataArray[$row][1]);
				$data[$row-1]['pwd'] = md5(trim($dataArray[$row][1]));
				if(empty($data[$row-1]['realname']) || empty($data[$row-1]['card']) || empty($data[$row-1]['pwd'])){
					$this -> error('错误：第'.$row.'行前列不能为空！','',10);
				}
				$data[$row-1]['status'] = 1;
				$data[$row-1]['uptime'] = time();
				if(session('cid') == ''){
					$this -> error('你不属于任何企业，不能导入！');
				}else{
					$data[$row-1]['cid'] = session('cid');
				}
				$dids = trim($dataArray[$row][2]);//所属部门
				if($dids != ''){
					$dids = str_replace('，',',',$dids);//替换中文逗号
					$dids_arr = explode(',',$dids);
					for($i=0;$i<count($dids_arr);$i++){
						$dids_arr[$i] = '.'.$dids_arr[$i].'.';
					}
					$dids_str = implode(',',$dids_arr);
					$data[$row-1]['dids'] = $dids_str;
				}
				$jids = trim($dataArray[$row][3]);//所属职位
				if($jids != ''){
					$jids = str_replace('，',',',$jids);//替换中文逗号
					$jids_arr = explode(',',$jids);
					for($i=0;$i<count($jids_arr);$i++){
						$jids_arr[$i] = '.'.$jids_arr[$i].'.';
					}
					$jids_str = implode(',',$jids_arr);
					$data[$row-1]['jids'] = $jids_str;
				}
				$data[$row-1]['gids'] = 5;
				$data[$row-1]['creater'] = session('realname');
				
				//关联权限中间表
				$data[$row-1]['middle'] = array(
					'group_id' => $data[$row-1]['gids'],
				);
				
				//关联电话表表
				$data[$row-1]['tel'] = array(
					'vtel' => $dataArray[$row][4],
					'fulltel' => $dataArray[$row][5],
					'otel' => $dataArray[$row][6],
					'hometel' => $dataArray[$row][7],
					'familytel' => $dataArray[$row][8],
					'mail' => $dataArray[$row][9],
					'uptime' => time(),
				);
			}
			
			//执行批量添加
			$user = D('user');
			$i = 0;
			$err_card = array();
			foreach($data as $one){
				if(count($user->where('card="'.$one['card'].'"')->select())<1){
					$user -> relation(array('middle','tel')) -> add($one);
					$i++;
				}else{
					$err_card[] = array($one['realname'],$one['card']);
				}
			}
			if($i == count($data)){
				$this -> success('成功添加 '.$i.' 条数据！',U('user/index'),60);
			}elseif($i>0){
				echo '<div style="text-align:center">以下数据导入失败：<div>';
				foreach($err_card as $err_d){
					echo $err_d[0].' : '.$err_d[1].'<br>';
				}
				echo '可能已有重复的身份证了！</div></div>';
				$this -> success('成功添加 '.$i.' 条数据！',U('user/index'),60);
			}else{
				$this -> error('导入失败！','',10);
			}
		}
		
	}
	
	public function r_manage(){
		return array(
			'writeexcel' => '导入excel数据',
			'readexcel' => '导出excel数据',
		);
	}
}