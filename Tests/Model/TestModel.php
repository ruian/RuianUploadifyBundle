<?php
namespace Ruian\UploadifyBundle\Tests\Model;

/**
* 
*/
class TestModel
{
    protected $embed;

    function __construct()
    {
        
    }

    public function setEmbed($value)
    {
        $this->embed = $value;   
    }

    public function getEmbed()
    {
        return $this->embed;
    }
}