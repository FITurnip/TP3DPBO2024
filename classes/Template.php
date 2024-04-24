<?php

class Template
{
    var $filename = '';
    var $content = '';

    public function __construct($filename = '')
    {
        $this->filename = $filename;

        $this->content = implode('', @file($filename));
    }

    protected function clear()
    {
        $this->content = preg_replace("/DATA_[A-Z|_|0-9]+/", "", $this->content);
    }

    protected function write()
    {
        $this->clear();
        print $this->content;
    }

    protected function getContent()
    {
        $this->clear();
        return $this->content;
    }

    protected function replace($old = '', $new = '')
    {
        if (is_int($new)) {
            $value = sprintf("%d", $new);
        } elseif (is_float($new)) {
            $value = sprintf("%f", $new);
        } elseif (is_array($new)) {
            $value = '';

            foreach ($new as $item) {
                $value .= $item . ' ';
            }
        } else {
            $value = $new;
        }
        $this->content = preg_replace("/$old/", $value, $this->content);
    }
}
