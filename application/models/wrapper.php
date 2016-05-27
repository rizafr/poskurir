<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Wrap the data for client server communication
 *
 * @author Sumapala Technologies
 */
class Wrapper extends CI_Model
{

	function __construct()
    {
      parent::__construct();
    }
    
    function wrap_post()
    {
    
    
    }
    
    function dewrap_post()
    {
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        $datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $datas);
        
        /*
        $clean = preg_replace(
                array(
                    '/\x00/', '/\x01/', '/\x02/', '/\x03/', '/\x04/',
                    '/\x05/', '/\x06/', '/\x07/', '/\x08/', '/\x09/', '/\x0A/',
                    '/\x0B/','/\x0C/','/\x0D/', '/\x0E/', '/\x0F/', '/\x10/', '/\x11/',
                    '/\x12/','/\x13/','/\x14/','/\x15/', '/\x16/', '/\x17/', '/\x18/',
                    '/\x19/','/\x1A/','/\x1B/','/\x1C/','/\x1D/', '/\x1E/', '/\x1F/'
                ),
                
                array(
                    "\\u0000", "\\u0001", "\\u0002", "\\u0003", "\\u0004",
                    "\\u0005", "\\u0006", "\\u0007", "\\u0008", "\\u0009", "\\u000A",
                    "\\u000B", "\u000C", "\\u000D", "\\u000E", "\\u000F", "\\u0010", "\\u0011",
                    "\\u0012", "\u0013", "\\u0014", "\\u0015", "\\u0016", "\\u0017", "\\u0018",
                    "\\u0019", "\\u001A", "\\u001B", "\\u001C", "\\u001D", "\\u001E", "\\u001F"
                ),
                $datas
        );
        */
        
        //echo json_encode($clean);
        
        $data = json_decode($clean);
        return $data;
    
    }
	
}