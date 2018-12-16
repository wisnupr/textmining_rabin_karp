<?php

class Rabinkarp_model{

    //ALGORITMA RABIN KARP
    function rabinkarp($teks1, $teks2, $gram) {
        
        $teks1White = $this->whiteInsensitive($teks1);
        // print_r($teks1White);
        $teks2White = $this->whiteInsensitive($teks2);
        // print_r($teks2White);
        $teks1Gram = $this->kGram($teks1White, $gram);
        // print_r($teks1Gram);
        $teks2Gram = $this->kGram($teks2White, $gram);
        // print_r($teks2Gram);
        $teks1Hash = $this->hash($teks1Gram);
        // print_r($teks1Hash);
        $teks2Hash = $this->hash($teks2Gram);
        // print_r($teks2Hash);
        $fingerprint = $this->fingerprint($teks1Hash, $teks2Hash);
        // print_r($fingerprint);
        $unique = $this->unique($fingerprint);

        $hasiluniq = $this->fingerprint($unique, $teks1Hash);

        $similiarity = $this->SimilarityCoefficient($hasiluniq, $teks1Hash, $teks2Hash);
        return $similiarity;

    }

    function whiteInsensitive($teks) {
        
        $a = $teks;
        $b = preg_replace("/[^a-z0-9_\-\.]/i", "-", $a);
        $c = explode("-", $b); //misah string berdasarkan -
        $e = '';
        $f = '';
        for ($d = 0; $d < count($c); $d++) {
            if (trim($c[$d]) != "")
                $e .= $c[$d] . "";
        }
        $e = strtolower(substr($e, 0, strlen($e) - 1));
        $f = str_replace(array(".", "_"), "", $e);
        return $f;
    }

    
    function kGram($teks, $gram) {
        $i = 0;
        $length = strlen($teks);
        $teksSplit;
        if (strlen($teks) < $gram) {
            $teksSplit[] = $teks;
        } else {
            for ($i; $i <= $length - $gram; $i++) {
                // echo " ";
                // echo "{";
                $teksSplit[] = substr($teks, $i, $gram);
                // print_r($teksSplit[] = substr($teks, $i, $gram));
                // echo " | ";
                // echo "} ";
            }
        }
        return $teksSplit;
    }

    
    function hash($gram) {
        $hashGram = null;
        foreach ($gram as $a => $teks) {
            
            if ($this->cekHash($teks, $hashGram) != true) {
                
                $hashGram[] = $this->rollingHash($teks);
                // print_r( $hashGram[] = $this->rollingHash($teks));
                // echo " - ";
                
            }

        }
        return $hashGram;
    }

    
    function rollingHash($string) {
        $basis = 11;
        $pjgKarakter = strlen($string);
        $hash = 0;
        for ($i = 0; $i < $pjgKarakter; $i++) {
            $ascii = ord($string[$i])."<br>";
            $hash += $ascii * pow($basis, $pjgKarakter - ($i + 1));
        }
        // return $hash;
        return $hash % 101;
    }

    
    function fingerprint($hash1, $hash2) {
        $fingerprint = null;
        $hashUdahDicek = null;
        $sama = false;
        $countHash1 = count($hash2);
        for ($i = 0; $i < count($hash1); $i++) {
            for ($j = 0; $j < $countHash1; $j++) {
                if ($hash1[$i] == $hash2[$j]) {
                    if ($this->cekHash($hash1[$i], $hashUdahDicek) == false) {
                        // echo "<b>";
                        // print_r($fingerprint[] = $hash1[$i]);
                        $fingerprint[] = $hash1[$i];
                        // echo "</b>";
                    }
                    $sama = true;
                } else {
                    $sama = false;
                }
            }
            if ($sama == true) {
                $hashUdahDicek[] = $hash1[$i];
            }
        }
        return $fingerprint;
    }
// coba fingerprint
    function unique($fingerprint) {
        $clear = array_unique($fingerprint);
        $hasilunique = null;
        foreach ($clear as $row) {
                
        $hasilunique[] = $row;

        }
        return $hasilunique;
    }
    // coba finger print
    function cekHash($hash, $hashUdahDicek) {
        $value = false;
        $countHashUdahDicek = count($hashUdahDicek);
        if ($countHashUdahDicek > 0) {
            for ($k = 0; $k < $countHashUdahDicek; $k++) {
                if ($hashUdahDicek[$k] == $hash) {
                    $value = true;
                    break;
                }
            }
        }
        return $value;
    }

   
    function similarityCoefficient($hasilunique, $hash1, $hash2) {
    	// echo count($fingerprint);
    	// echo "<br>";
    	// echo count($hash1);
    	// echo "<br>";
    	// echo count($hash2);
        return number_format(((2 * count($hasilunique) / (count($hash1) + count($hash2))) * 100), 2, '.', '');
    
    }

}?>
