<?php

include('classes/BaseView.php');
include('classes/CardView.php');
include('classes/User.php');

$user_datas = new User();

$base = new BaseView();
$card_view = new CardView();

if (isset($_GET['search'])) {
    $datas = $user_datas->search($_GET['search'])->get();
} else {
    $datas = $user_datas->get();
}

$card_view->insert_content([
    "title" => "Users",
    "datas" => $datas,
    "placeholders" => [
        "__DETAIL_URL__" => "detail_url",
        "__IMAGENAME__" => "imagename",
        "__DATA0__" => "username",
        "__DATA1__" => "password",
        "__DATA2__" => "user_id"
    ]
]);

$base->insert_content($card_view->get_view());

$base->show();