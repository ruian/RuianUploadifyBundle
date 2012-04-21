<?php
namespace Ruian\UploadifyBundle\Tests;

use Ruian\UploadifyBundle\Form\Extension\Uploadify\UploadifyExtension;
use Ruian\UploadifyBundle\Tests\Extension\Core\Type\TypeTestCase;

class UploadifyExtensionTest extends TypeTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function GoutteTest()
    {
        
    }

    public function testEnableUploadify()
    {
        $view = $this->factory
            ->createBuilder('form', null, array())
            ->add($this->factory->createNamedBuilder('text', 'child', "hello world", array(
                'uploadify_enabled' => true,
                'uploadify' => array(
                    
                )
            )))
            ->getForm()
            ->createView();

            //var_dump($view->getChild('child')->getVars());

        $this->assertTrue(true);
    }

    protected function getExtensions()
    {
        return array_merge(parent::getExtensions(), array(
            new UploadifyExtension($this->router, $this->token, array()),
        ));
    }
}