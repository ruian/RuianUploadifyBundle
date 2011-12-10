Feature: add a support for uploadify librarie
    As a developper 
    I want to add embed form with a standars data-xxx and transfer session to uploadify request

    Scenario: Simple Process
        Given I create a model who embed "Ruian\UploadifyBundle\Model\Ressource"
        And I create a form who embed "Ruian\UploadifyBundle\Form\RessourceType"
        When I render my form
        And I make a upload request with 
         | session | folder   | Filedata |
         | xxxxxxx | /uploads | foo      |
        Then I should see:
            """
            {"folder":"\/uploads","file":"foo"}
            """
    