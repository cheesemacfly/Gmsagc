<?php

namespace NGPP\GmsagcBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoldsControllerTest extends WebTestCase
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
        $this->client->request('GET', $this->router->generate('ngpp_gmsagc_molds'));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        
        $this->client->request('GET', $this->router->generate('ngpp_gmsagc_molds', ['f' => 'a']));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }
    
    public function testSave()
    {
        $crawler = $this->client->request('GET', $this->router->generate('ngpp_gmsagc_molds_save'));
        $this->assertTrue($this->client->getResponse()->isSuccessful());
        
        $form = $crawler->selectButton('Sauvegarder')->form();
        $crawler = $this->client->submit($form, array(
            'ngpp_gmsagcbundle_moldstype[id]' => '1',
            'ngpp_gmsagcbundle_moldstype[name]' => 'Gmsagc_Test_molds',
            'ngpp_gmsagcbundle_moldstype[weight]' => '1234.56',
            'ngpp_gmsagcbundle_moldstype[shell]' => '4321'
        ));
        $this->assertTrue($this->client->getResponse()->isRedirect($this->router->generate('ngpp_gmsagc_molds')));
        
        $crawler = $this->client->followRedirect();
        $this->assertCount(1, $crawler->filter('div.alert-success'));
  
        $crawler = $this->client->request('GET', $this->router->generate('ngpp_gmsagc_molds', ['f' => 'Gmsagc_Test_molds']));
        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $link = $crawler->selectLink('Editer')->link();
        $crawler = $this->client->click($link);
        $form = $crawler->selectButton('Sauvegarder')->form();
        $crawler = $this->client->submit($form, array(
            'ngpp_gmsagcbundle_moldstype[weight]' => '1234.56',
            'ngpp_gmsagcbundle_moldstype[shell]' => '4321'
        ));
        $this->assertTrue($this->client->getResponse()->isRedirect($this->router->generate('ngpp_gmsagc_molds')));
        
        $crawler = $this->client->followRedirect();
        $this->assertCount(1, $crawler->filter('div.alert-success'));  
    }
    
    public function testDelete()
    {
        $crawler = $this->client->request('GET', $this->router->generate('ngpp_gmsagc_molds', ['f' => 'Gmsagc_Test_molds']));
        $this->assertTrue($this->client->getResponse()->isSuccessful());

        $link = $crawler->selectLink('Editer')->link();
        $crawler = $this->client->click($link);
        $link = $crawler->selectLink('Supprimer')->link();
        $crawler = $this->client->click($link);
        $this->assertTrue($this->client->getResponse()->isRedirect($this->router->generate('ngpp_gmsagc_molds')));
        
        $crawler = $this->client->followRedirect();
        $this->assertCount(1, $crawler->filter('div.alert-success'));        
    }
}
