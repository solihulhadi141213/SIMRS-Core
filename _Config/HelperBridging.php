<?php
    //FUNGSI ENCRYPT DAN DECRYPT BRIDGING BPJS

    //decrypt
    function decrypt_string_aes256cbc($key, $string){
        $encrypt_method = 'AES-256-CBC';
        $key_hash       = hex2bin(hash('sha256', $key));
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv     = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        return $output;
    }
    
    // decompress lzstring 
    function decompress_stirng($string){
        return \LZCompressor\LZString::decompressFromEncodedURIComponent($string);
    }
?>