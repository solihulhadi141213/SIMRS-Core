<?php
    if(isset($_FILES['file'])){
		$file = $_FILES['file'];
        if(!empty($file['tmp_name'])){
            $TmpFile=$file['tmp_name'];
            $bin_string = file_get_contents($TmpFile);
            $hex_string = base64_encode($bin_string);
            echo $hex_string;
        }
	}else{
        
    }
?>