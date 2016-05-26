<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mobile Order Controller
 *
 * @author PT. Pos Indonesia
 */
class Mobilecomm{
    function senddatatomobile($message)
    {
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");
        
        $datas = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $message, MCRYPT_MODE_CBC, $iv);
        $endatas = base64_encode($datas);
        return $endatas;
    }
    
    function getdatafrommobile()//not tested
    {
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        $datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $datas);
        $data = json_decode($clean);
        
        return $data;
    }
    
    function mdecrypt($ciphertext)//not tested
    {
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents($ciphertext));
        $datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $datas);
        $data = json_decode($clean);
        
        return $data;
    }
    
}