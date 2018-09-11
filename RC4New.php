<?php
   
    /**
     * Avalanche Effect in change bit key
     */

     echo '===Avalanche Effect in change bit key===<br/><br/>';

    // variable inisialization
    $keyScheduling = array();
    $keyScheduling2 = array();
    $keyScheduling3 = array();
    $keyStream = array();
    $keyStream2 = array();
    $keyStream3 = array();
    $keyStream4 = array();
    
    // Key Scheduling Algorithm
    $keyScheduling = keySchedulingAlgorithm('122');
    $keyScheduling2 = keySchedulingAlgorithm('123');
    
    // Pseudo Random Generator Algorithm
    $keyStream = pseudoRandomGeneratorAlgorithm($keyScheduling, '123');
    $keyStream2 = pseudoRandomGeneratorAlgorithm($keyScheduling2, '123');
    
    // cipher text
    $output = outPut($keyStream, '123');
    $output2 = outPut($keyStream2, '123');

    echo 'Key 1 = 122<br/>';
    echo 'Key 2 = 123<br/>';
    echo 'Plain Text = 123<br/>';
    echo '-----------------------------<br/>';
    echo 'Cipher Text 1 = ' . $output . '<br/>';
    echo 'Cipher Text 2 = ' . $output2 . '<br/>';

    // Avalanche Effect
    avalancheEffect($output, $output2);

    /**
     * Avalanche Effect in change bit plain text
     */
    
     echo '<br/><br/>===Avalanche Effect in change bit plain text===<br/><br/>';
    
    // Key Scheduling Algorithm
    $keyScheduling3 = keySchedulingAlgorithm('ABCDE');
    
    // Pseudo Random Generator Algorithm
    $keyStream3 = pseudoRandomGeneratorAlgorithm($keyScheduling3, 'ABCDE');
    $keyStream4 = pseudoRandomGeneratorAlgorithm($keyScheduling3, 'ABCDF');
    
    // cipher text
    $cipherText1 = outPut($keyStream3, 'ABCDE');
    $cipherText2 = outPut($keyStream4, 'ABCDF');

    echo 'Key = ABCDE<br/>';
    echo 'Plain Text 1= ABCDE<br/>';
    echo 'Plain Text 2= ABCDF<br/>';
    echo '-----------------------------<br/>';
    echo 'Cipher Text 1 = ' . $cipherText1 . '<br/>';
    echo 'Cipher Text 2 = ' . $cipherText2 . '<br/>';

    // Avalanche Effect
    avalancheEffect($cipherText1, $cipherText2);
 

    // echo '<br/> ---';
    // echo $output;
    // echo '<br/> ---';
    // echo $output2;
    // echo '<br/>';
    // $plainText = outPut($keyStream, $output);
    // echo $plainText;
    // echo '<br/>';
    // echo '<br/>';

    // avalancheEffect('123', '122');
    // function for Algorithm keyScheduling from input key
    function keySchedulingAlgorithm($keyString){
        
        // variable inisialisation
        $S = array();
        $keyDecimal = array();

        // variable instantiation
        $keyLength = strlen($keyString);

        // convert string key into ascii number
        for ($i = 0; $i < $keyLength; $i++) { 
            
            $keyDecimal[$i] = ord($keyString[$i]);
        }

        // variable instantiation of state
        for($i = 0; $i < 256; $i++) {

            $S[$i] = $i;
        }

        // variable instantiation of index j
        $j = 0;

        // iteration for swapping key value
        for ($i = 0; $i < 256; $i++) { 
        
            $j = ($j + $S[$i] + $keyDecimal[$i % $keyLength]) % 256;
            
            $temp = $S[$i];
            $S[$i] = $S[$j];
            $S[$j] = $temp;
        }

        // return the value of state
        return $S;
    }

     // function for Algorithm pseudo Random Generator from $keyScheduling and $plainText 
    function pseudoRandomGeneratorAlgorithm($keyScheduling, $plainText){

        // variable inisialisation
        $keyStream = array();

        // variable instantiation
        $plainTextLength = strlen($plainText);
        $i = 0;
        $j = 0;
        
        // iteration for generate random number from $plainTextLength and $keyScheduling
        for ($iteration = 0; $iteration < $plainTextLength; $iteration++) { 
            
            $i = ($i + 1) % 256;
            $j = ($j + $keyScheduling[$i]) % 256;

            $temp = $keyScheduling[$i];
            $keyScheduling[$i] = $keyScheduling[$j];
            $keyScheduling[$j] = $temp;

            $keyStream[$iteration] = $keyScheduling[($keyScheduling[$i] + $keyScheduling[$j]) % 256];
        }

        // return the value of keystream
        return $keyStream;
    }

    // function for bitwise operator (XOR) between plaintext and keystream
    //and convert into char
    function outPut($keyStream, $plainText) {
        
        // variable inisialisation
        $output = '';

        // iteration for bitwise operator (XORing)
        for ($i = 0; $i < strlen($plainText); $i++) { 
            
            $output .= chr(ord($plainText[$i]) ^ $keyStream[$i]);
            
        }

        // return the value of output
        return $output;
    }

    // function for measurement avalancheEffect of cryptofgraphy algorithm
    function avalancheEffect($cipherText1, $cipherText2){
        
        // variable instantiation
        $counter = 0;
        $totalBit = 8 * strlen($cipherText1);

        echo '<br/>Result :<br/>';

        // iteration from cipherText length
        for ($i=0; $i < strlen($cipherText1); $i++) { 
            
            // converting character from cipherText into decimal ASCII
            $charToDecimal = ord($cipherText1[$i]);
            $charToDecimal2 = ord($cipherText2[$i]);

            // converting decimal into binary
            $decimalToBin = decbin($charToDecimal);
            $decimalToBin2 = decbin($charToDecimal2);

            // adding 0 infront of decimal to become 8 bits
            $eightBit = str_pad($decimalToBin, 8, 0, STR_PAD_LEFT);
            $eightBit2 = str_pad($decimalToBin2, 8, 0, STR_PAD_LEFT);

            // iteration for checking value bits
            for($j = 0; $j < 8; $j++){

                // when bit is not equal, counter increase
                if ($eightBit[$j] != $eightBit2[$j]) {
                
                    $counter++;
                }
            }

            // showing each char and each bit
            echo 'char from cipher text 1 = ' . $cipherText1[$i] . '   bit = '. $eightBit . '<br/>';
            echo 'char from cipher text 2 = ' . $cipherText2[$i] . '   bit = '. $eightBit2 . '<br/>';
            echo '-----------<br/>';
        }

        // showing the output of avalancheEffect
        echo 'Total bit different = ' . $counter . '<br/>';
        echo 'Total bit = ' . $totalBit . '<br/>';
        echo 'Avalanche Effect = '. ($counter / $totalBit) * 100 . '%';
    }

?>