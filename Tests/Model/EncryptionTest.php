<?php
use Ruian\UploadifyBundle\Model\Encryption;

class EncryptionTest extends \PHPUnit_Framework_TestCase
{
    public function testEncryptDecrypt()
    {
        $enc = new Encryption('kknmknmknmknmnm');
        $string = 'hello world';
        $string_enc = $enc->encrypt($string);

        $this->assertEquals($string, $enc->decrypt($string_enc));
    }
}
