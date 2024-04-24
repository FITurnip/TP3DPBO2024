<?php
include_once "Resource.php";

class Balance extends Resource
{
    private string $table_name = 'balances';

    public function __construct() {
        parent::__construct($this->table_name);
    }

    public function join() {
        return $this->inner_join('accounts', 'account_id', 'account_id');
    }

    public function search($keyword) {
        return $this->where('name', 'LIKE', "%$keyword%");
    }

    public function get($column = ['balance_id', 'name', 'account_number', 'record_date', 'debit', 'credit', 'balance']) {
        return $this->get_data($column);
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
