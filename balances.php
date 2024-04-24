<?php

include('classes/BaseView.php');
include('classes/TableView.php');
include('classes/Balance.php');

$balance_datas = new Balance();

$base = new BaseView();
$table_view = new TableView();

if (isset($_GET['search'])) {
    $datas = $balance_datas->join()->search($_GET['search'])->get();
} else {
    $datas = $balance_datas->join()->get();
}

$table_view->insert_content([
    "title" => "Balance",
    "datas" => $datas,
]);

$base->insert_content($table_view->get_view());

$base->show();