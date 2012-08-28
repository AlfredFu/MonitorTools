<?php

    $submit_log=$_REQUEST['submit_log'];
    $submit_log=trim($submit_log);
    if(!empty($submit_log)){
        $code_list_arr=explode("\n",$submit_log);
	$code_list_arr=array_map('trim',$code_list_arr);
        sort($code_list_arr);
	$duplicateList=array();
	$trimDuplicateList=array();
	foreach($code_list_arr as $key=>$value){
		if(in_array($value,$trimDuplicateList)){
			$duplicateList[]=$value;
		}else{
			$trimDuplicateList[]=$value;
		}
	}
	$result="duplicate file list:\n<br/>";
	$result.=implode("\n<br/>",$duplicateList);
	$result.="<br/><br/>\n<br/>trim duplicate file list:\n<br/>";
	$result.=implode("\n<br/>",$trimDuplicateList);
	$code_list_num=count($trimDuplicateList);
   } 


?>
<HTML>

<HEAD>
<title>Get submit file list</title>
<script language='javascript' src='jquery-1.7.1.js'></script>
<script type='text/javascript'>
    function getfl(){
        //$('#flcform').submit();
        return true;
    }
    function mergefl(){
        $('#actionType').val('2'); 
        //$('#flcform').submit();
        return false;
    }
</script>
</HEAD>

<BODY>

<form id='flcform' name='flcform' action='' method='post' >

<div style='width:1300px;'>
    <div style='float:left;width:600px;height:600px;'>
        <input type='hidden' name='actionType' id="actionType" value='1'/>
        <textarea id='submit_log' name='submit_log' cols='70' rows='35'>
        <?php
            echo $_REQUEST['submit_log'];
        ?>
        </textarea>
    </div>
    <div style='width:60px;height:600px;float:left;padding:0 20px 0 20px'>
        <input id='getfl' name='getfl' type='submit' value='>>>>' />
    </div>
    <div style='float:right;width:600px;height:600px;'>
        <p>File list number:<?php echo $code_list_num;?></p>
        <p>
            <?php
                echo $result;
            ?>
        </p>
    </div>
</div>


</form>
</BODY>
</HTML>
<?php
?>
