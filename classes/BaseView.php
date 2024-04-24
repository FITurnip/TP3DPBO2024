<?php
include_once "View.php";

class BaseView extends View {
    private string $marker;
    private Template $header, $footer;
    public function __construct() {
        parent::__construct('templates/base.html');
        $this->header = new Template('templates/header.html');
        $this->footer = new Template('templates/footer.html');

        $this->replace('__HEADER__', $this->header->getContent());
        $this->replace('__FOOTER__', $this->footer->getContent());

        $this->marker = '__BASE__';
    }

    public function set_marker($marker) {
        $this->marker = $marker;
    }

    public function get_marker() {
        return $this->marker;
    }

    public function insert_content($content) {
        parent::replace($this->marker, $content);
    }

    public function get_view() {
        return parent::getContent();
    }

    public function show() {
        parent::write();
    }
}