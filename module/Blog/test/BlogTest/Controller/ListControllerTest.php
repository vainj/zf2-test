<?php

namespace BlogTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Blog\Model\Post;

class ListControllerTest extends AbstractHttpControllerTestCase
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

    public function testIndexActionCanBeAccessed()
    {
        $this->getPostServiceInterfaceMock('findAllPosts');

        $this->dispatch('/blog');
        $this->assertResponseStatusCode(200);
    }

    public function testDetailActionCanBeAccessed()
    {
        $post = new Post();

        $this->getPostServiceInterfaceMock('findPost', $post);

        $this->dispatch('/blog/123');
        $this->assertResponseStatusCode(200);
    }
}
