<?php
include_once "Resource.php";
include_once "User.php";

class Account extends Resource
{
    private string $table_name = 'accounts';

    public function __construct() {
        parent::__construct($this->table_name);
    }

    public function join() {
        return $this->inner_join('users', 'user_id', 'user_id');
    }

    public function search($keyword) {
        return $this->where('name', 'LIKE', "%$keyword%");
    }

    public function byId($account_id) {
        return $this->where('account_id', '=', $account_id);
    }

    public function get($columns = ['account_id', 'username', 'name', 'address', 'account_number', 'imagename']) {
        $result = $this->get_data($columns);
        return $result;
    }

    private function uploadImage($image) {
        if($image["tmp_name"] != null) {
            $target_file = "assets/images/" . basename($image["name"]);
            move_uploaded_file($image["tmp_name"], $target_file);
        }
        return $image["name"];
    }

    public function store($request) {
        $request["account_number"] = "A12345678";
        
        // store data to user
        $user_data = [
            "username" => $request["username"],
            "email" => $request["email"],
            "password" => $request["password"],
            "imagename" => ($this->uploadImage($request["imagename"]) != null ? $request["imagename"]["name"] : "noPhoto.png")
        ];
        $user = new User();

        $user_insert_id = $user->store($user_data);

        // store data to account
        $account_data["user_id"] = $user_insert_id;
        $account_data["name"] = $request["name"];
        $account_data["address"] = $request["address"];
        $account_data["account_number"] = $request["account_number"];

        return $this->store_data($account_data);
    }

    public function update($oldData, $request) {
        // update data to user
        $user_data = [
            "username" => $request["username"],
            "email" => $request["email"],
            "password" => $request["password"],
            "imagename" => ($this->uploadImage($request["imagename"]) != null ? $request["imagename"]["name"] : "noPhoto.png")
        ];

        // update data to account
        $account_data["name"] = $request["name"];
        $account_data["address"] = $request["address"];
        $account_data["account_number"] = $request["account_number"];

        return $this->update_data($oldData, $user_data + $account_data);
    }

    public function destroy($column, $value) {
        return $this->destroy_data($column, $value);
    }
}
