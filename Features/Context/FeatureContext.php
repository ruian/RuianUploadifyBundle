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

    /**
     * @Given /^I create new instance of "([^"]*)" who embed "([^"]*)"$/
     */
    public function iCreateNewInstanceOfWhoEmbed($argument1, $argument2)
    {
        $this->obj = new $argument1();
        $ressource = new $argument2();
        $this->obj->setEmbed($ressource);
    }

    /**
     * @When /^I create form with "([^"]*)" who embed "([^"]*)"$/
     */
    public function iCreateFormWithAnd($argument1, $argument2)
    {
        $container = $this->getContainer();
        if (new $argument1() instanceof $this->obj) {
            $this->form = $container->get('form.factory')->createBuilder('form', $this->obj, array())
            ->add('embed', new $argument2())
            ->getForm();
        } else {
            throw new Exception("$argument1 must be an instance of ".get_class($this->obj)."", 1);
        }
    }

    /**
     * @Given /^I set "([^"]*)" to "([^"]*)" from form$/
     */
    public function iSetToFromForm($argument1, $argument2)
    {
        $this->form['embed']->bindRequest();
    }

    /**
     * @Then /^I should get :$/
     */
    public function iShouldGet(PyStringNode $string)
    {
        throw new PendingException();
    }
}
