<?php
namespace Ruian\UploadifyBundle\Tests\Extension\Core\Type;

use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Extension\Core\CoreExtension;
use Symfony\Component\EventDispatcher\EventDispatcher;

abstract class TypeTestCase extends \PHPUnit_Framework_TestCase
{
    protected $factory;

    protected $builder;

    protected $dispatcher;

    protected $router;

    protected $token;

    protected function setUp()
    {
        if (!class_exists('Symfony\Component\EventDispatcher\EventDispatcher')) {
            $this->markTestSkipped('The "EventDispatcher" component is not available');
        }

        $this->router = $this->getMockBuilder('Symfony\Component\Routing\Router')->disableOriginalConstructor()->getMock();
        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->token = $this->getMockBuilder('Ruian\UploadifyBundle\Model\Encrypt')->disableOriginalConstructor()->getMock();
        $this->factory = new FormFactory($this->getExtensions());
        $this->builder = new FormBuilder(null, $this->factory, $this->dispatcher);
    }

    protected function tearDown()
    {
        $this->builder = null;
        $this->dispatcher = null;
        $this->factory = null;
    }

    protected function getExtensions()
    {
        return array(
            new CoreExtension(),
        );
    }
}
