<?php

namespace Ruian\UploadifyBundle\Features\Context;

use Behat\BehatBundle\Context\BehatContext,
    Behat\BehatBundle\Context\MinkContext;
use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Exception;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends BehatContext //MinkContext if you want to test web
{
//
// Place your definition and hook methods here:
//
//    /**
//     * @Given /^I have done something with "([^"]*)"$/
//     */
//    public function iHaveDoneSomethingWith($argument)
//    {
//        $container = $this->getContainer();
//        $container->get('some_service')->doSomethingWith($argument);
//    }
//
    protected $obj;
    protected $form;
    protected $result;

    /**
     * @Given /^I create a model who embed "([^"]*)"$/
     */
    public function iCreateAModelWhoEmbed($ressource)
    {
        $this->obj = new \Ruian\UploadifyBundle\Tests\Model\TestModel();
        $this->obj->setEmbed(new $ressource());
    }

    /**
     * @Given /^I create a form who embed "([^"]*)"$/
     */
    public function iCreateAFormWhoEmbed($ressourceType)
    {
        $container = $this->getContainer();
        $this->form = $container->get('form.factory')->createBuilder('form', $this->obj, array())
            ->add('embed', new $ressourceType())
            ->getForm();
    }

    /**
     * @When /^I render my form$/
     */
    public function iRenderMyForm()
    {
        $form_view = $this->form->createView();
    }

    /**
     * @Given /^I make a upload request with$/
     */
    public function iMakeAUploadRequestWith(TableNode $table)
    {
        $table = array_shift($table->getHash());
        $ressource = $this->obj->getEmbed();
        $ressource->setFile($table['Filedata']);
        $ressource->setFolder($table['folder']);
        try {
            $ressource->upload();
        } catch (FileException $e) {
            
        }
        $this->result = json_encode($ressource->toArray());
    }

    /**
     * @Then /^I should see:$/
     */
    public function iShouldSee(PyStringNode $string)
    {
        if (0 !== strcmp($string, $this->result)) {
            throw new Exception("$this->result not equal to $string", 1);
        }
    }

}
