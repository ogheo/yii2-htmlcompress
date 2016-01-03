<?php

namespace smilemd\htmlcompress;

/**
 * Class View
 * @package smilemd\htmlcompress
 */
class View extends \yii\web\View
{
    /**
     * Enable or disable compression, by default compression is enabled.
     *
     * @var bool
     */
    public $compress = true;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->compress === true) {
            \Yii::$app->response->on(\yii\web\Response::EVENT_BEFORE_SEND, function (\yii\base\Event $Event) {
                $Response = $Event->sender;
                if ($Response->format === \yii\web\Response::FORMAT_HTML) {
                    if (!empty($Response->data)) {
                        $Response->data = self::compress($Response->data);
                    }
                    if (!empty($Response->content)) {
                        $Response->content = self::compress($Response->content);
                    }
                }
            });
        }
    }

    /**
     * HTML compress function.
     *
     * @param $html
     * @return mixed
     */
    private static function compress($html)
    {
        $filters = array(
            // remove HTML comments except IE conditions
            '/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/us' => '',
            // remove comments in the form /* */
            '/(?<!\S)\/\/\s*[^\r\n]*/u' => '',
            // shorten multiple white spaces
            '/>\s{2,}</u' => '> <',
            // shorten multiple white spaces
            '/\s{2,}/u' => ' ',
            // collapse new lines
            '/(\r?\n)/u' => '',
        );

        $output = preg_replace(array_keys($filters), array_values($filters), $html);

        return $output;
    }
}
