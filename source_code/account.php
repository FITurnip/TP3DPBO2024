<?php
include_once "classes/BaseView.php";
include_once "classes/DetailView.php";
include_once "classes/TableView.php";
include_once "classes/FormView.php";
include_once "classes/Account.php";
include_once "classes/User.php";
include_once "classes/Balance.php";

// Check if the request method is POST and _method field is present
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method'])) {
    // Override the request method with the value from _method field
    $_SERVER['REQUEST_METHOD'] = strtoupper($_POST['_method']);
}

$base = new BaseView();
$account = new Account();
$user = new User();

switch ($_SERVER['REQUEST_METHOD']) {
    case "GET":
        if (isset($_GET["action"])) {
            if ($_GET["action"] == "update") {
                $account_data = $account->join()->byId($_GET["id"])->get(['username', 'email', 'name', 'address', 'imagename']);
                $account_form_data = [
                    "url" => "account.php?id=$_GET[id]",
                    "method" => "POST",
                    "inputs" => [
                        ["name" => "username", "value" => $account_data[0]["username"]],
                        ["name" => "email", "type" => "email", "value" => $account_data[0]["email"]],
                        ["name" => "password", "type" => "password", "value" => ""],
                        ["name" => "name", "value" => $account_data[0]["name"]],
                        ["name" => "address", "value" => $account_data[0]["address"]],
                        ["name" => "imagename", "type" => "file"],
                        ["name" => "_method", "type"=> "hidden", "value" => "put"]
                    ],
                    "submit" => "Update Account"
                ];
            } else if ($_GET["action"] == "store") {
                $account_form_data = [
                    "url" => "account.php",
                    "method" => "POST",
                    "inputs" => [
                        ["name" => "username", "value" => ""],
                        ["name" => "email", "type" => "email", "value" => ""],
                        ["name" => "password", "type" => "password", "value" => ""],
                        ["name" => "name", "value" => ""],
                        ["name" => "address", "value" => ""],
                        ["name" => "imagename", "type" => "file"],
                    ],
                    "submit" => "Add Account"
                ];
            }

            $account_form = new FormView();
            $account_form->insert_content($account_form_data);
            $base->insert_content($account_form->get_view());
        } else if (isset($_GET["id"])) {
            $detail_view = new DetailView();
            $table_view = new TableView();
            $balance = new Balance();

            $account_data = $account->join()->byId($_GET["id"])->get(["name", "address", "account_number", "username", "email", "password", "imagename"]);
            $detail_view->insert_content([
                "title" => "Account",
                "data" => $account_data[0],
                "update_url" => "account.php?id=$_GET[id]&action=update",
                "delete_url" => "account.php?id=$_GET[id]"
            ]);

            $balance_datas = $balance->join();
            if (isset($_GET['orderby'])) {
                $balance_datas = $balance_datas->ordered($_GET['orderby'], (isset($_GET['ordertype']) ? ($_GET["ordertype"] == "ASC") : false));
            }
            
            $columnOrdered = [
                "column" => (isset($_GET["orderby"]) ? $_GET["orderby"] : null),
                "type" => (isset($_GET["ordertype"]) ? $_GET["ordertype"] : "ASC")
            ];
            
            $balance_datas = $balance->search([
                'key' => 'accounts.account_id',
                'comparation' => '=',
                'keyword' => $_GET["id"]
            ]);

            $balance_datas = $balance_datas->get();

            $table_view->insert_content([
                "title" => "Balance",
                "datas" => $balance_datas,
                "columnOrdered" => $columnOrdered
            ]);

            $detail_view->continue_content($table_view->get_view());
            $base->insert_content($detail_view->get_view());
        } else {
            header("Location: ./account.php?action=store");
            die();
        }
        break;
    case "POST":
        $request = $_POST + $_FILES;

        $result = $account->store($request);
        header("Location: ./account.php?id=$result");
        die();
        break;
    case "DELETE":
        $user_data = $account->byId($_GET["id"])->get(["user_id"]);
        $user_data_id = $user_data[0]["user_id"];
        $user->destroy("user_id", $user_data_id);
        header("Location: ./index.php");
        die();
        break;
    case "PUT":
        $new_account_data = [
            "name" => $_POST["name"],
            "address" => $_POST["address"],
        ];
        $new_user_data = [
            "username" => $_POST["username"],
            "email" => $_POST["email"],
            "password" => $_POST["password"],
        ];
        $oldData = ["column" => "account_id", "id" => $_GET["id"]];
        $account->join()->update($oldData, $new_account_data + $new_user_data + $_FILES);
        header("Location: ./account.php?id=$_GET[id]");
        die();
        break;
}
$base->show();
?>

