<?php
include_once "View.php";
class FormView extends View {
    private array $marker;
    public function __construct() {
        parent::__construct('templates/form.html');

    }
    public function set_marker($marker) {
        $this->marker = $marker;
    }

    public function get_marker() {
        return $this->marker;
    }

    public function get_inputs($datas) {
        $inputs = "";
        foreach ($datas as $data) {
            $inputs .= ($data["type"] != "hidden" ? "<label for='$data[name]'>$data[name]</label><br/>" : "");
            $inputs .= "<input name='$data[name]' type='$data[type]' value='$data[value]' class='form-control' " . ($data["type"] != "file" ? "required" : "") . "/><br/>";
        }

        return $inputs;
    }
    public function insert_content($content) {
        $this->replace('__SUBMIT_URL__', $content["url"]);
        $this->replace('__SUBMIT_METHOD__', $content["method"]);
        $this->replace('__SUBMIT_VALUE__', $content['submit']);
        $this->replace('__INPUT_LIST__', $this->get_inputs($content["inputs"]));
    }

    public function get_view() {
        return $this->getContent();
    }

    public function show() {
        $this->write();
    }

}