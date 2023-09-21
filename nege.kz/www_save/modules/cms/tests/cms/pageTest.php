<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @group cms_module
 */
class pageTest extends Unittest_TestCase
{
    /**
     * @var Cms_Page
     */
    protected $page;

    protected $session;

    public function setUp()
    {
        parent::setUp();
        $this->session=$this->getMock("Kohana_Session_Native",array(),array(),"",false);
        $this->page=new Cms_Page(null,$this->session);
        $this->page->document_root(MODPATH."cms/tests");
        $this->page->content_dir("tests/data/media");
    }
    /**
     * @covers Cms_Page::find_content()
     */
    public function testFindContentUrl()
    {
        $url="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js";
        $this->assertEquals($url,$this->page->find_content($url));
    }
    /**
     * @covers Cms_Page::find_content()
     */
    public function testFindContentFile()
    {
        $file="data/jquery.min.js";
        $this->assertEquals($file,$this->page->find_content($file));
        $file="jquery.min.js";
        $this->assertEquals($file,$this->page->find_content($file));
        $this->assertFileExists(Kohana::find_file("tests","jquery.min","js"));
    }

    /**
     * @covers Cms_Page::find_content()
     * @expectedException Kohana_Exception
     */
    public function testFindFileNotFound()
    {
        $this->page->find_content("file_not_exist");
    }


    /**
     * @covers Cms_Page::headers()
     */
    public function testHeaders()
    {
        $this->assertTrue(is_array($this->page->headers("scripts")));
        $this->assertTrue(is_array($this->page->headers("styles")));
        $this->assertTrue(is_array($this->page->headers("meta")));

        $this->assertNull($this->page->headers("scripts","jquery"));
        $this->page->script("jquery","data/jquery.min.js");
        $this->assertEquals("data/jquery.min.js",$this->page->headers("scripts","jquery"));
        $this->page->style("style","data/style.css");
        $this->assertEquals("data/style.css",$this->page->headers("styles","style"));

    }

    /**
     * @covers Cms_page::read_messages()
     */
    public function testMessages(){
        $arr=Cms_Page::read_messages(Cms_Page::PAGE_MESSAGE_NOTICE);
        $this->assertTrue(is_array($arr));
        Cms_Page::message("message1");
        $arr=Cms_Page::read_messages(Cms_Page::PAGE_MESSAGE_NOTICE);
        $this->assertTrue(is_array($arr));
        $this->assertEquals(1,count($arr));

    }
    /**
     * @covers Cms_Page::save_messages()
     */
    public function testMessageLoadAndSave()
    {
        $messages=array("one","two","three");

        $this->session->expects($this->once())
            ->method("get")
            ->with($this->equalTo("cms_page_messages"))
            ->will($this->returnValue(array(Cms_Page::PAGE_MESSAGE_NOTICE=>$messages)));
        $page=new Cms_Page(null,$this->session);
        $arr=$page->read_messages(Cms_Page::PAGE_MESSAGE_NOTICE);
        $this->assertEquals($messages,$arr);
        $this->session->expects($this->once())
                    ->method("set")
                    ->with($this->equalTo("cms_page_messages"),$this->equalTo(array(Cms_Page::PAGE_MESSAGE_NOTICE=>$messages)));
        $page->message($messages,Cms_Page::PAGE_MESSAGE_NOTICE);
        $page->save_messages();
    }

    public function tearDown()
    {
        $file=Kohana::find_file("tests","jquery.min","js");
        if (is_file($file))
        {
            unlink($file);
        }
        parent::tearDown();
    }


}
