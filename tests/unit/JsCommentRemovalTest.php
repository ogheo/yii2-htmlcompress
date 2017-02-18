<?php

namespace smilemdunit\htmlcompress\unit;

use smilemd\htmlcompress\View;

class JsCommentRemovalTest extends \PHPUnit\Framework\TestCase
{

    public function testUrlWithComment()
    {
        $this->assertEquals(View::compress('<script>\'http://should.not.be.removed\' // hue</script>'), '<script>\'http://should.not.be.removed\' </script>');
    }

    public function testUrlWithoutRemoveInsideQuotehttp()
    {
        $this->assertEquals(View::compress('<script>"http://should.not.be.removed"</script>'), '<script>"http://should.not.be.removed"</script>');
    }

    public function testUrlWithoutRemoveInsideApostrofe()
    {
        $this->assertEquals(View::compress('<script>\'https://should.not.be.removed\'</script>'), '<script>\'https://should.not.be.removed\'</script>');
    }

    public function testUrlWithoutRemoveInsideQuotehttps()
    {
        $this->assertEquals(View::compress('<script>"https://should.not.be.removed"</script>'), '<script>"https://should.not.be.removed"</script>');
    }

    public function testUrlWithoutRemoveUrlWithoutHttpInsideQuote()
    {
        $this->assertEquals(View::compress('<script>\'//should.not.be.removed\'</script>'), '<script>\'//should.not.be.removed\'</script>');
    }

    public function testUrlWithoutRemoveUrlWithoutHttpInsideApostrofe()
    {
        $this->assertEquals(View::compress('<script>"//should.not.be.removed"</script>'), '<script>"//should.not.be.removed"</script>');
    }

    public function testUrlWithoutRemoveUrlObject()
    {
        $this->assertEquals(View::compress('<script>{
            foo://should.be.removed
            lala:"//should.not.be.removed"
            haja:"//should.not.be.removed"//should be removed but ok if not
            lalala:"//should.not.be.removed",//should be removed
            yolo:"https://should.not.be.removed";//should be removed
            yolo:"http://should.not.be.removed";//should be removed
        }</script>'),
            '<script>{ foo: lala:"//should.not.be.removed" haja:"//should.not.be.removed" lalala:"//should.not.be.removed", yolo:"https://should.not.be.removed"; yolo:"http://should.not.be.removed"; }</script>');
    }


    public function testUrlWithRemoveCommentInStartOfAPage()
    {
        $this->assertEquals(View::compress('<script>//should be removed</script>'), '<script></script>');
    }

    public function testUrlWithRemoveCommentWithSpace()
    {
        $this->assertEquals(View::compress('<script>test// should be removed</script>'), '<script>test</script>');
    }

    public function testUrlWithRemoveCommentWithUrlSpace()
    {
        $this->assertEquals(View::compress('<script>test// http://should be removed</script>'), '<script>test</script>');
    }

    public function testUrlWithRemoveCommentWithUrlWithoutSpace()
    {
        $this->assertEquals(View::compress('<script>test//http://should.be.removed</script>'), '<script>test</script>');
    }

    public function testUrlWithRemoveCommentUrlCheck()
    {
        $this->assertEquals(View::compress('<script>https://should.be.removed</script>'), '<script>https:</script>');
    }
    public function testUrlWithoutRemoveCommentUrlCheckInsideString()
    {
        $this->assertEquals(View::compress('<script>"yolo yolo yolo https://should.not.be.removed.but.ok.if.removed yolo yolo yolo"</script>'), '<script>"yolo yolo yolo https://should.not.be.removed.but.ok.if.removed yolo yolo yolo"</script>');
    }

    public function testUrlWithoutRemoveCommentDoubleUrlCheckInsideString()
    {
        $this->assertEquals(View::compress('<script>"https://should.not.be.removed", "https://should.not.be.removed"</script>'), '<script>"https://should.not.be.removed", "https://should.not.be.removed"</script>');
    }

    public function testUrlWithRemoveCommentAfterString()
    {
        $this->assertEquals(View::compress('<script>"https://should.not.be.removed", "//should.not.be.removed" //shoud be removed</script>'), '<script>"https://should.not.be.removed", "//should.not.be.removed" </script>');
    }

    public function testUrlWithoutRemoveCommentTwoSeparateUrlStrings()
    {
        $this->assertEquals(View::compress('<script>"https://should.not.be.removed", "//should.not.be.removed"</script>'), '<script>"https://should.not.be.removed", "//should.not.be.removed"</script>');
    }

    public function testUrlWithRemoveCommentRandomString()
    {
        $this->assertEquals(View::compress('<script>ahaha: "//trolololo.com"//should be removed</script>'), '<script>ahaha: "//trolololo.com"</script>');
    }
}