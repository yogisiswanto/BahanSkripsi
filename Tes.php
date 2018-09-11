<?php

    include "RC6.php";

    $RC6 = new RC6();
    // $RC6->index();
    $key = $RC6->keySchedule("12345");
            // print_r($key);
            // print_r(blockConverter("yogi"));
    echo strlen($chiper = $RC6->encrypt("123456789", $key));
    // echo $hasilReverseBlock = $RC6->reverseBlockConverter($chiper);
    echo "<br/>";
    // echo $plaintext = $RC6->decrypt($chiper, $key);
    // $hasilDecrypt = $RC6->reverseBlockConverter($plaintext);
    // echo strlen(base64_encode($hasilReverseBlock)) . " " . $hasilDecrypt;
    // echo strlen(str_pad('tes', 16));
    // for ($i=0; $i < strlen($chiper); $i++) { 
    
    //     $tampung[$i] = ord($chiper[$i])." ";
    // }

    // print_r($tampung);

    // echo "<br/>";

    // for ($i=0; $i < strlen($chiper); $i++) { 
        
    //     echo $chiper[$i]." ";
    // }

    echo hash("sha1","yogi");
?>