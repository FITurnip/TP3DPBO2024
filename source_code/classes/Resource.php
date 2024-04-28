<?php
include_once "TableDB.php";

abstract class Resource extends TableDB {
    private string $table_name;
    public abstract function get($columns = '*');
    public abstract function store($request);
    public abstract function update($oldData, $request);
    public abstract function destroy($column, $value);
}