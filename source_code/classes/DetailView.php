<?php
include_once "View.php";
class DetailView extends View {
    private array $marker;
    public function __construct() {
        parent::__construct('templates/detail.html');
    }

    public function set_marker($marker) {
        $this->marker = $marker;
    }

    public function get_marker() {
        return $this->marker;
    }

    public function continue_content($content) {
        $this->replace('__CONTINUE_HTML__', $content);
    }

    public function insert_content($content) {
        $this->replace('__TITLE__', $content["title"]);

        $table_data = "";

        $this->replace("__IMAGENAME__", $content["data"]["imagename"]);

        foreach ($content["data"] as $key => $value) {
            $table_data = $table_data . "<tr><td>$key</td><td>:</td><td>$value</td></tr>";
        }

        $this->replace('__TABLE_DATA__', $table_data);
        $this->replace('__UPDATE_URL__', $content["update_url"]);
        $this->replace('__DELETE_URL__', $content["delete_url"]);
    }

    public function get_view() {
        return $this->getContent();
    }

    public function show() {
        $this->write();
    }

}