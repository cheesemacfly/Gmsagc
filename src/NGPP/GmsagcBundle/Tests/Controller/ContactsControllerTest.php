<?php

namespace NGPP\GmsagcBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactsControllerTest extends WebTestCase
{
    private $client;
    private $router;
    
    public function __construct() 
    {
        $this->client = static::createClient();
        $this->router = $this->client->getContainer()->get('router');
    }
    
    public function testIndex()
    {        
        $this->client->request('GET', $this->router->generate('ngpp_gmsagc_contacts'));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        
        $this->client->request('GET', $this->router->generate('ngpp_gmsagc_contacts', ['f' => 'a']));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
    
    public function testSave()
    {
        $crawler = $this->client->request('GET', $this->router->generate('ngpp_gmsagc_contacts_save'));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        
        $form = $crawler->selectButton('Sauvegarder')->form();
        $crawler = $this->client->submit($form, array(
            'ngpp_gmsagcbundle_contactstype[name]' => 'Gmsagc_Test_Contacts',
            'ngpp_gmsagcbundle_contactstype[email]' => 'test@guelpa.me',
            'ngpp_gmsagcbundle_contactstype[phone]' => '(123)465-7890'
        ));
        $this->assertTrue($this->client->getResponse()->isRedirect($this->router->generate('ngpp_gmsagc_contacts')));
        
        $crawler = $this->client->followRedirect();
        $this->assertCount(1, $crawler->filter('div.alert-success'));
  
        $crawler = $this->client->request('GET', $this->router->generate('ngpp_gmsagc_contacts', ['f' => 'Gmsagc_Test_Contacts']));
        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $link = $crawler->selectLink('Editer')->link();
        $crawler = $this->client->click($link);
        $form = $crawler->selectButton('Sauvegarder')->form();
        $crawler = $this->client->submit($form, array(
            'ngpp_gmsagcbundle_contactstype[email]' => 'test2@guelpa.me',
            'ngpp_gmsagcbundle_contactstype[phone]' => '(098)765-4321'
        ));
        $this->assertTrue($this->client->getResponse()->isRedirect($this->router->generate('ngpp_gmsagc_contacts')));
        
        $crawler = $this->client->followRedirect();
        $this->assertCount(1, $crawler->filter('div.alert-success'));  
    }
    
    public function testDelete()
    {
        $crawler = $this->client->request('GET', $this->router->generate('ngpp_gmsagc_contacts', ['f' => 'Gmsagc_Test_Contacts']));
        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $link = $crawler->selectLink('Editer')->link();
        $crawler = $this->client->click($link);
        $link = $crawler->selectLink('Supprimer')->link();
        $crawler = $this->client->click($link);
        $this->assertTrue($this->client->getResponse()->isRedirect($this->router->generate('ngpp_gmsagc_contacts')));
        
        $crawler = $this->client->followRedirect();
        $this->assertCount(1, $crawler->filter('div.alert-success'));        
    }
}
