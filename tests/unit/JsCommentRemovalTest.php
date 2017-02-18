<?php

namespace smilemdunit\htmlcompress\unit;

use smilemd\htmlcompress\View;

class JsCommentRemovalTest extends \PHPUnit\Framework\TestCase
{

    public function testUrlWithComment()
    {
        $this->assertEquals(View::compress('\'http://should.not.be.removed\' // hue'), '\'http://should.not.be.removed\' ');
    }

    public function testUrlWithoutRemoveInsideQuotehttp()
    {
        $this->assertEquals(View::compress('"http://should.not.be.removed"'), '"http://should.not.be.removed"');
    }

    public function testUrlWithoutRemoveInsideApostrofe()
    {
        $this->assertEquals(View::compress('\'https://should.not.be.removed\''), '\'https://should.not.be.removed\'');
    }

    public function testUrlWithoutRemoveInsideQuotehttps()
    {
        $this->assertEquals(View::compress('"https://should.not.be.removed"'), '"https://should.not.be.removed"');
    }

    public function testUrlWithoutRemoveUrlWithoutHttpInsideQuote()
    {
        $this->assertEquals(View::compress('\'//should.not.be.removed\''), '\'//should.not.be.removed\'');
    }

    public function testUrlWithoutRemoveUrlWithoutHttpInsideApostrofe()
    {
        $this->assertEquals(View::compress('"//should.not.be.removed"'), '"//should.not.be.removed"');
    }

    public function testUrlWithoutRemoveUrlObject()
    {
        $this->assertEquals(View::compress('{
            foo://should.be.removed
            lala:"//should.not.be.removed"
            haja:"//should.not.be.removed"//should be removed but ok if not
            lalala:"//should.not.be.removed",//should be removed
            yolo:"https://should.not.be.removed";//should be removed
            yolo:"http://should.not.be.removed";//should be removed
        }'),
            '{ foo: lala:"//should.not.be.removed" haja:"//should.not.be.removed" lalala:"//should.not.be.removed", yolo:"https://should.not.be.removed"; yolo:"http://should.not.be.removed"; }');
    }

    public function testUrlWithRemoveCommentInStartOfAPage()
    {
        $this->assertEquals(View::compress('//should be removed'), '');
    }

    public function testUrlWithRemoveCommentWithSpace()
    {
        $this->assertEquals(View::compress('test// should be removed'), 'test');
    }

    public function testUrlWithRemoveCommentWithUrlSpace()
    {
        $this->assertEquals(View::compress('test// http://should be removed'), 'test');
    }

    public function testUrlWithRemoveCommentWithUrlWithoutSpace()
    {
        $this->assertEquals(View::compress('test//http://should.be.removed'), 'test');
    }

    public function testUrlWithRemoveCommentUrlCheck()
    {
        $this->assertEquals(View::compress('https://should.be.removed'), 'https:');
    }
    public function testUrlWithoutRemoveCommentUrlCheckInsideString()
    {
        $this->assertEquals(View::compress('"yolo yolo yolo https://should.not.be.removed.but.ok.if.removed yolo yolo yolo"'), '"yolo yolo yolo https://should.not.be.removed.but.ok.if.removed yolo yolo yolo"');
    }

    public function testUrlWithoutRemoveCommentDoubleUrlCheckInsideString()
    {
        $this->assertEquals(View::compress('"https://should.not.be.removed", "https://should.not.be.removed"'), '"https://should.not.be.removed", "https://should.not.be.removed"');
    }

    public function testUrlWithRemoveCommentAfterString()
    {
        $this->assertEquals(View::compress('"https://should.not.be.removed", "//should.not.be.removed" //shoud be removed'), '"https://should.not.be.removed", "//should.not.be.removed" ');
    }

    public function testUrlWithoutRemoveCommentTwoSeparateUrlStrings()
    {
        $this->assertEquals(View::compress('"https://should.not.be.removed", "//should.not.be.removed"'), '"https://should.not.be.removed", "//should.not.be.removed"');
    }

    public function testUrlWithRemoveCommentRandomString()
    {
        $this->assertEquals(View::compress('ahaha: "//trolololo.com"//should be removed'), 'ahaha: "//trolololo.com"');
    }

    public function testUrlWithoutRemoveCommentShortenUrl()
    {
        $this->assertEquals(View::compress('//blabla.com'), '//blabla.com');
    }



    

}