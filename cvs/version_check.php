<?php
	//$output=shell_exec('ls');
	//echo $output."\n";
	/*$output=shell_exec('cvs log -tN alpha/topic/config/config.php');
	preg_match_all('/head:\s+([\d.]*)/',$output,$matches);
	print_r($matches);
	echo $output."\n";
	set_time_limit(3000);
	*/
	//$developerArr=array('Fred','Kevin','Jeff','Leo');
	//$developerArr=array('Fred','Rock');
	$developerArr=array('jeff');
	$needMergeArr=array();
	$nonExistFileArr=array();
	foreach($developerArr as $developer){
		$fileArr=array();
		$fhandle=fopen("lists/$developer.txt",'r');
		while(!feof($fhandle)){
			$fileArr[]=fgets($fhandle);
		}
		fclose($fhandle);
		//print_r($fileArr);
		foreach($fileArr as $fileName){
			//echo "file:".getFileName($fileName)."\n";
			//echo "version:".getFileVersion($fileName)."\n";
			//echo "-----------------------------------------\n";	
			if(!trim($fileName))continue;
			$pureFileName=getFileName($fileName);
			$branchVersion=trim(getFileVersion($fileName));
			$branchLatestVersion=trim(getBranchLatestVersion($fileName,$branchVersion));
			$headVersion=trim(getHeadVersion($pureFileName));
			//if(strpos('simple_search_result.html',$fileName)){
			//echo "$pureFileName,$branchVersion,$branchLatestVersion,$headVersion\n";
			//}
			if($branchLatestVersion){
				if(versionComp($headVersion,$branchVersion) || versionComp($branchLatestVersion,$branchVersion)){
					$needMergeArr[]=array(
							'head'=>$pureFileName." ".$headVersion,
							'branch'=>$pureFileName." ".trim($branchVersion),
							'branch_latest'=>$pureFileName." ".$branchLatestVersion."(Owner:$developer)"
						);
				}
			}else{
				$nonExistFileArr[]=$fileName;		
			}
		
		}
	}
	$result="";
	if(!empty($needMergeArr)){
		$result.= "code need to merge:\n";
		foreach($needMergeArr as $f){
			$result.="Head version:".$f['head']."\nBranch version:".$f['branch']."\nBranch latest version:".$f['branch_latest']."\n\n";
		}
	}
	if(!empty($nonExistFileArr)){
		$result.= "code doesn't exist:\n";
		foreach($nonExistFileArr as $f){
			$result.=$f."\n";
		}
	}
	echo $result;
	//print_r($needMergeArr);
//	echo	getBranchLatestVersion("/law/template/simple_search_result.html 1.50.4.5");
//	echo "\n";

	/*if $ver1 is latest return true,else return false*/
	function versionComp($ver1,$ver2){
		$result=false;
		if($ver1 && $ver2){
			$ver1Arr=explode('.',trim($ver1));
			$ver2Arr=explode('.',trim($ver2));
			for($i=0;$i<count($ver1Arr);$i++){
				if(intval($ver1Arr[$i])>intval($ver2Arr[$i])){
					$result=true;
					break;
				}		
			}
		}	
		return $result;
	}
	function getFileName($filelist){
		$fileName=preg_replace('/\s+[\d\.]*\s*/','',$filelist);
		return $fileName;
	}
	function getFileVersion($filelist){
		return preg_replace('/([\/\w-\+]+[\.\w\+-]*)\s*([\.\d]*)/','\2',$filelist);
	}
	function getHeadVersion($fileName){
		$logCommand="cvs log -tN alpha$fileName";
//echo $logCommand."\n";
		$logInfo=shell_exec($logCommand);
		preg_match_all('/head:\s+([\d.]*)/',$logInfo,$matches);
		$versionInfo=$matches[1][0];
		return $versionInfo;
	}
	/*检测分支版本号是否是最新的*/	
	function getBranchLatestVersion($fileName,$branchVersion){
		//$branchVersion=getFileVersion($fileName);
		$pureFileName=getFileName($fileName);
		$logCommand="cvs log -N -r".trim($branchVersion).": alpha$pureFileName";
		//echo $logCommand;
		$logInfo=shell_exec($logCommand);	
		//preg_match('/revision\s*[\d.]+/',$logInfo,$matches);
		preg_match_all('/revision\s*([\d.]+)/',$logInfo,$all_matches);
		return $all_matches[1][0];
	}
	function detectReversionExist($fileName,$branchVersion){
		$pureFileName=getFileName($fileName);
		$logCommand="cvs log -N -r".trim($branchVersion).": alpha$pureFileName";
		$logInfo=shell_exec($logCommand);
	}

