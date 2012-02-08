<?php
namespace Ruian\UploadifyBundle\Model;

/**
* 
*/
class Encrypt
{
    protected $key;
    protected $cipher = MCRYPT_BLOWFISH;
    protected $mode   = MCRYPT_MODE_ECB;

    public function __construct($key)
    {        
        $this->key = $key;
    }

    public function encrypt($data)
    {
        return base64_encode(rtrim(mcrypt_encrypt($this->cipher, $this->key, $data, $this->mode)));
    }

    public function decrypt($data)
    {
        return rtrim(mcrypt_decrypt($this->cipher, $this->key, base64_decode($data), $this->mode));
    }
}