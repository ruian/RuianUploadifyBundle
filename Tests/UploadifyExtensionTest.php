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
                    'auto' => false
                )
            )))
            ->getForm()
            ->createView();
        $vars = $view->getChild('child')->getVars();
        $uploadify = json_decode($vars['attr'][1], true);
        $this->assertTrue($uploadify['auto'] == false);
    }

    protected function getExtensions()
    {
        return array_merge(parent::getExtensions(), array(
            new UploadifyExtension($this->router, $this->token, $this->container),
        ));
    }
}