<?php
use Ruian\UploadifyBundle\Model\Encrypt;

class EncryptTest extends \PHPUnit_Framework_TestCase
{
    public function testEncryptDecrypt()
    {
        $enc = new Encrypt('kknmknmknmknmnm');
        $string = 'hello world';
        $string_enc = $enc->encrypt($string);

        $this->assertEquals($string, $enc->decrypt($string_enc));
    }
}
