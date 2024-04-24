<?php
include_once "View.php";
class TableView extends View {
    private $title;
    private $table_header_html;
    private $table_row_html;
    private $marker;

    public function __construct() {
        parent::__construct('templates/table.html');
    }

    public function set_marker($marker) {
        $this->marker = $marker;
    }

    public function get_marker() {
        return $this->marker;
    }

    public function set_title($title) {
        $this->title = $title;
    }

    public function set_table_header($datas) {
        $first_row = $datas[0];
        $this->table_header_html = "";

        foreach($first_row as $key => $value) {
            $this->table_header_html = $this->table_header_html . "<th>$key</th>";
        }
    }

    public function set_table_row($datas) {
        foreach($datas as $data) {
            $td_temp = "";
            foreach($data as $value) {
                $td_temp = $td_temp . "<td>$value</td>";
            }
            $this->table_row_html[] = "<tr>$td_temp</tr>";
        }
    }

    public function insert_content($content){
        $this->set_title($content["title"]);
        $this->replace('__DATA_MAIN_TITLE__', $this->title);
        $this->set_table_header($content["datas"]);
        $this->replace('__DATA_TABEL_HEADER__', $this->table_header_html);
        $this->set_table_row($content["datas"]);
        $this->replace('__DATA_TABEL__', $this->table_row_html);
    }

    public function get_view() {
        return $this->getContent();
    }

    public function show() {
        $this->write();
    }
}