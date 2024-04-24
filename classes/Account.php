<?php
include_once "Resource.php";

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

    public function get($columns = ['account_id', 'username', 'name', 'address', 'account_number', 'imagename']) {
        $result = $this->get_data($columns);
        return $result;
    }

    public function store($request) {
        return $this->store_data($request);
    }

    public function update($request) {
        return $this->update_data($request);
    }

    public function destroy($column, $value) {
        return $this->destroy_data($column, $value);
    }
}
