<?php

    $submit_log=$_REQUEST['submit_log'];
    $submit_log=trim($submit_log);
    if(!empty($submit_log)){
        $code_list_arr=explode("\n",$submit_log);
        arsort($code_list_arr);
        
        $pure_code=array();
        $version_arr=array();
        foreach($code_list_arr as $key=>$value){
            $tmparr=explode(" ",$value);
            $pure_code[$key]=$tmparr[0];
            $version_arr[$key]=$tmparr[1];
        }
        $pure_code=array_unique($pure_code);
        $result_list=array();
        foreach($pure_code as $key=>$value){
           $result_list[]=$value." ".$version_arr[$key]; 
        }
        asort($result_list);
        $code_list=implode(" \n<br/>\n",$result_list);
        $code_list_num=count($result_list);
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

<form id='flcform' name='flcform' action='merge.php' method='post' >

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
                echo $code_list;
            ?>
        </p>
    </div>
</div>


</form>
</BODY>
</HTML>
<?php
?>
