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

    public function set_table_header($datas, $columnOrdered) {
        $first_row = $datas[0];
        $this->table_header_html = "";
        $currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";

        $itr = 0;
        $totalItems = count($_GET);
        $otherOrderParam = false;

        foreach($_GET as $key => $value) {
            if ($itr == 0) $currentURL .= "?";
            $itr++;
            
            if ($key == "ordertype") {
                if($_GET["orderby"] == $columnOrdered["column"]) {
                    if($_GET["ordertype"] == "ASC") $val = "DESC";
                    else $val = "ASC";
                } else {
                    $val = $value;
                }
                $orderParam = "orderby=$_GET[orderby]&ordertype=$val";
            } else if($key != "orderby") {
                $currentURL .= "$key=$value";
                $otherOrderParam = true;
                if ($itr < $totalItems) $currentURL .= "&";
            }
            
        }
        
        $ascOrderSymbol = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
            <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
        </svg>';
        $descOrderSymbol = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
        </svg>';

        foreach($first_row as $key => $value) {
            $orderType = ($columnOrdered["column"] == $key ? ($columnOrdered["type"] == "ASC" ? "DESC" : "ASC") : "ASC");
            $orderSymbol = ($orderType == "ASC" ? $ascOrderSymbol : $descOrderSymbol);
            
            $orderParam = "orderby=$key&ordertype=" . $orderType;
            $url = "$currentURL" . ($otherOrderParam ? "&" : "?") . "$orderParam";
            $this->table_header_html = $this->table_header_html . "<th><a href='$url'>$key  $orderSymbol</a></th>";
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
        $this->set_table_header($content["datas"], $content["columnOrdered"]);
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