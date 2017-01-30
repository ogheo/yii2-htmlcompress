<?php

namespace smilemdunit\htmlcompress\unit;

use smilemd\htmlcompress\View;

class JsCommentRemovalTest extends \PHPUnit\Framework\TestCase
{
    public function testAllSingleLineCommentsRemoved()
    {
        $file = file_get_contents(__DIR__ . '/../files/line_comments.txt');
        $file = View::compress($file);

        $this->assertEquals(file_get_contents(__DIR__ . '/../files/no_line_comments.txt'), $file);
    }
}