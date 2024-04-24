<?php
include_once "Resource.php";

class User extends Resource
{
    private string $table_name = 'users';

    public function __construct() {
        parent::__construct($this->table_name);
    }
    
    public function search($keyword) {
        return $this->where('username', 'LIKE', "%$keyword%");
    }

    public function get($column = "*") {
        return $this->get_data();
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
