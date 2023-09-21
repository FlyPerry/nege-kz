<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @group cms_module
 */
class controllerTest extends Unittest_TestCase
{
    /**
     * @var Cms_Controller
     */
    protected $controller;
    protected $MockOrm;
    protected $MockSession;
    protected $MockRequest;
    protected $MockResponse;
    protected $MockPage;
    public function setUp()
    {
        parent::setUp();
        $this->MockRequest=$this->getMock("Request",array(),array("/"));
        $this->MockResponse=$this->getMock("Response");
        $this->MockPage=$this->getMock("Cms_Page");
        $this->controller=new Cms_Controller($this->MockRequest,$this->MockResponse);
        $this->controller->page=$this->MockPage;
    }

    public function testBefore()
    {
        $this->controller->before();
    }

    /**
     * @depends testBefore
     */
    public function testAfter()
    {
        $this->MockPage->expects($this->at(1))
            ->method("save_messages");
        $this->MockResponse->expects($this->once())
            ->method("body");
        $this->controller->template=$this->getMockBuilder("View")
            ->disableOriginalConstructor()
            ->setMethods(array("render"))
            ->getMock();
        $this->controller->after();
        $this->controller->render=false;
        $this->controller->after();
    }

}
