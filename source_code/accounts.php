<?php

include('classes/BaseView.php');
include('classes/CardView.php');
include('classes/Account.php');

$account_datas = new Account();

$base = new BaseView();
$card_view = new CardView();

if (isset($_GET['search'])) {
    $datas = $account_datas->join()->search($_GET['search'])->get();
} else {
    $datas = $account_datas->join()->get();
}

$card_view->insert_content([
    "title" => "Accounts",
    "datas" => $datas,
    "detail_url" => "account.php",
    "placeholders" => [
        "__DETAIL_ID__" => "account_id",
        "__IMAGENAME__" => "imagename",
        "__DATA0__" => "name",
        "__DATA1__" => "username",
        "__DATA2__" => "address"
    ]
]);

$base->insert_content($card_view->get_view());

$base->show();