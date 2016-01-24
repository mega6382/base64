<?php

/**
 * Object Oriented PHP base64 encoder and decoder
 * copyright : (c) 2016 ZOCUX TECHNOLOGIES
 * version PHP : > 4
 * author : haseeb@zocuxtech.com
 * licence : GPL
 *
*/
class Base64{
	
     ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //        CHANGE THE VALUE OF THE FOLLOWING STRING TO CUSTOMIZE THE ENCODING. BUT DON'T CHANGE THE LENGTH OF THE STRING   //
   ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	protected $codes = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
	
     ////////////////////////////////////////////////
    //        DECODES BASE64 INTO TEXT            //
   ////////////////////////////////////////////////
    public function decode($input){
		$codes = $this->codes;
		try {
			if($input == null)
			{
				throw new Exception("INPUT IS NULL");
			}
			} catch (Exception $e) {
				die(isset($e->xdebug_message)? $e->xdebug_message : $e->getMessage());
			}
		try {
				if (strlen($input) % 4 != 0)
				{
					throw new Exception("INVALID BASE64 STRING");
				}
			} catch (Exception $e) {
				die(isset($e->xdebug_message)? $e->xdebug_message : $e->getMessage());
			}
        $decoded[] = ((strlen($input) * 3) / 4) - (strrpos($input,'=') > 0 ? (strlen($input) - strrpos($input,'=')) : 0);
        $inChars = str_split($input);
        $j = 0;
        $b = array();
        for ($i = 0; $i < count($inChars); $i += 4) {
            $b[0] = strpos($codes,$inChars[$i]);
            $b[1] = strpos($codes,$inChars[$i + 1]);
            $b[2] = strpos($codes,$inChars[$i + 2]);
            $b[3] = strpos($codes,$inChars[$i + 3]);
            $decoded[$j++] = (($b[0] << 2) | ($b[1] >> 4));
            if ($b[2] < 64)      {
                $decoded[$j++] = (($b[1] << 4) | ($b[2] >> 2));
                if ($b[3] < 64)  {
                    $decoded[$j++] = (($b[2] << 6) | $b[3]);
	        }
            }
        }
		$decodedstr = '';
		for($i=0;$i<count($decoded);$i++)
		{
				$decodedstr .= chr($decoded[$i]);

		}
        return $decodedstr;
    }
     ///////////////////////////////////////////////
    //        ENCODES TEXT INTO BASE64           //
   ///////////////////////////////////////////////
    public function encode($in){
		$codes = $this->codes;
		$inlen = strlen($in);
		$in = str_split($in);
		$out = '';
        $b = '';
        for ($i = 0; $i < $inlen; $i += 3)  {
            $b = (ord($in[$i]) & 0xFC) >> 2;
            $out .= ($codes[$b]);
            $b = (ord($in[$i]) & 0x03) << 4;
            if ($i + 1 < $inlen) {
                $b |= (ord($in[$i + 1]) & 0xF0) >> 4;
                $out .= ($codes[$b]);
                $b = (ord($in[$i + 1]) & 0x0F) << 2;
                if ($i + 2 < $inlen)  {
                    $b |= (ord($in[$i + 2]) & 0xC0) >> 6;
                    $out .= ($codes[$b]);
                    $b = ord($in[$i + 2]) & 0x3F;
                    $out .= ($codes[$b]);
                } else  {
                    $out .= ($codes[$b]);
                    $out .= ('=');
                }
            } else{
                $out .= ($codes[$b]);
                $out .= ("==");
            }
        }

        return $out;
    }
}
//example
$bs = new base64;
var_dump($bs->decode("dGVzdA=="));
var_dump($bs->encode("test"));
