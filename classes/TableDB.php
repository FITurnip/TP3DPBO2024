<?php
include_once "DB.php";
include_once "config/db.php";

class TableDB extends DB {
    private string $table_name;
    private string $inner_join_query;
    private string $where_query;

    public function __construct(string $table_name) {
        global $DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME;
        parent::__construct($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
        $this->table_name = $table_name;
        $this->inner_join_query = "";
        $this->where_query = "";
    }

    private function split_request($request) {
        $columns = implode(', ', array_keys($request));
        
        $values = "'" . implode("', '", array_values($request)) . "'";
    
        return array($columns, $values);
    }

    private function execute_query(string $sql, string $type) {
        $this->open();

        if ($type == "affected") $result = $this->executeAffected($sql);
        else if($type == "fetch") {
            $this->execute($sql);
            while ($row = $this->getResult()) {
                $result[] = $row;
            }
        } else {
            $result = "error";
        }
    
        $this->close();
    
        return $result;
    }

    protected function inner_join(string $table_name, string $key, string $foreign_key) {
        $this->inner_join_query = " INNER JOIN $table_name ON $table_name.$key = $this->table_name.$foreign_key";
        return $this;
    }

    protected function where(string $key, string $comparation, $value) {
        if(is_string($value)) $value = "'$value'";
        $this->where_query = " WHERE $key $comparation $value";
        return $this;
    }

    protected function get_data($columns = '*') {
        try {
            if (!is_string($columns)) $columns = implode(', ', $columns);
            $sql = "SELECT $columns FROM $this->table_name" . $this->inner_join_query . $this->where_query;
            $result = $this->execute_query($sql, "fetch");
            $this->inner_join_query = "";
            $this->where_query = "";
            return $result;
        } catch (Exception $e) {
            return "Error fetching data: " . $e->getMessage();
        }
    }

    protected function store_data($request) {
        try {
            list($columns, $values) = $this->split_request($request);
            $sql = "INSERT INTO $this->table_name ($columns) VALUES ($values)";
            return $this->execute_query($sql, "affected");
        } catch (Exception $e) {
            return "Error storing data: " . $e->getMessage();
        }
    }
    
    protected function update_data($request) { // still bad
        try {
            list($columns, $values) = $this->split_request($request);
            $sql = "UPDATE $this->table_name SET $columns = $values";
            return $this->execute_query($sql, "affected");
        } catch (Exception $e) {
            return "Error updating data: " . $e->getMessage();
        }
    }

    protected function destroy_data($column, $value) {
        try {
            $sql = "DELETE $this->table_name WHERE $column = $value";
            return $this->execute_query($sql, "affected");
        } catch (Exception $e) {
            return "Error destroying data: " . $e->getMessage();
        }
    }
}