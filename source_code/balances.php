<?php

include('classes/BaseView.php');
include('classes/TableView.php');
include('classes/Balance.php');

$balance_datas = new Balance();

$base = new BaseView();
$table_view = new TableView();

if (isset($_GET['search'])) {
    $request_search = ["key" => "name", "comparation" => "LIKE", "keyword" => "%$_GET[search]%"];
    $datas = $balance_datas->join()->search($request_search);
} else {
    $datas = $balance_datas->join();
}

if (isset($_GET['orderby'])) {
    $datas = $datas->ordered($_GET['orderby'], (isset($_GET['ordertype']) ? ($_GET["ordertype"] == "ASC") : false));
}

$columnOrdered = [
    "column" => (isset($_GET["orderby"]) ? $_GET["orderby"] : null),
    "type" => (isset($_GET["ordertype"]) ? $_GET["ordertype"] : "ASC")
];

$datas = $datas->get();

$table_view->insert_content([
    "title" => "Balance",
    "datas" => $datas,
    "columnOrdered" => $columnOrdered
]);

$base->insert_content($table_view->get_view());

$base->show();