<?php

namespace BlogTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Blog\Model\Post;

class DeleteControllerTest extends AbstractHttpControllerTestCase
{
    protected $traceError = true;
    
    public function setUp()
    {
        $this->setApplicationConfig(
            include '/config/application.config.php'
        );
        parent::setUp();
    }

    private function getPostServiceInterfaceMock($method, $returnValue = array())
    {
        $postServiceIMock = $this->getMockBuilder('Blog\Service\PostServiceInterface')
            ->disableOriginalConstructor()
            ->getMock();
            
        $postServiceIMock->expects($this->once())
            ->method($method)
            ->will($this->returnValue($returnValue));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('Blog\Service\PostServiceInterface', $postServiceIMock);

        return $postServiceIMock;
    }

    public function testDeleteActionCanBeAccessed()
    {
        $post = new Post();

        $this->getPostServiceInterfaceMock('findPost', $post);

        $postData = array(
            'id'     => '123',
            'del'    => 'yes'
        );

        $this->dispatch('/blog/delete/123', 'POST', $postData);
        $this->assertResponseStatusCode(302);
        $this->assertRedirectTo('/blog');
    }
}
