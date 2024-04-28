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

    public function search($request) {
        $key = ($request["key"] ? $request["key"] : 'id');
        $comparation = ($request["comparation"] ? $request["comparation"] : '=');
        $keyword = ($request["keyword"] ? $request["keyword"] : 'id');

        return $this->where($key, $comparation, $keyword);
    }

    public function ordered(string $column, bool $asc) {
        return $this->order($column, $asc);
    } 

    public function get($column = ['balance_id', 'name', 'account_number', 'record_date', 'debit', 'credit', 'balance']) {
        return $this->get_data($column);
    }

    public function store($request) {
        return $this->store_data($request);
    }

    public function update($oldData, $request) {
        return $this->update_data($oldData, $request);
    }

    public function destroy($column, $value) {
        return $this->destroy_data($column, $value);
    }
}
