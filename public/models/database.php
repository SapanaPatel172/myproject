<?php
class database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "myprojectdata";
    public $conn;
    //constructor
    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    //insert data into database
    public function insertdata($tablename, $data)
    {
        // Separate field names and values from the associative array
        $fields = implode(", ", array_keys($data));
        $values = implode(", ", array_map(function ($value) {
            // Escape and quote strings
            return is_string($value) ? "'" . $this->conn->real_escape_string($value) . "'" : $value;
        }, $data));

        // Build the INSERT query
        $qur = "INSERT INTO $tablename ($fields) VALUES ($values)";

        // Execute the query
        $get_query_result = $this->conn->query($qur);

        if ($get_query_result) {
            // Return the ID of the last inserted record
            return $this->conn->insert_id;
        } else {
            // Return false if the query failed
            return false;
        }
    }

    //update data 
    public function updatedata($tablename, $data, $condition)
    {
        // Build the SET part of the UPDATE query
        $setClause = implode(", ", array_map(function ($field, $value) {
            $formattedValue = is_string($value) ? "'" . $this->conn->real_escape_string($value) . "'" : $value;
            return "$field=$formattedValue";
        }, array_keys($data), $data));

        // Build the WHERE part of the UPDATE query
        $whereClause = implode(" AND ", array_map(function ($field, $value) {
            $formattedValue = is_string($value) ? "'" . $this->conn->real_escape_string($value) . "'" : $value;
            return "$field=$formattedValue";
        }, array_keys($condition), $condition));

        // Build the complete UPDATE query
        $qur = "UPDATE $tablename SET $setClause WHERE $whereClause";

        // Execute the query
        $get_query_result = $this->conn->query($qur);

        return $get_query_result;
    }

    //select data from database
    public function selectdata($tablename, $wherevalue = [])
    {
        $conditions = [];

        foreach ($wherevalue as $field => $value) {
            $formattedValue = is_string($value) ? "'" . $this->conn->real_escape_string($value) . "'" : $value;
            $conditions[] = "$field = $formattedValue";
        }

        $whereClause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : '';

        $qur = "SELECT * FROM $tablename $whereClause";

        $get_query_result = $this->conn->query($qur);
        return $get_query_result;
    }
    
    //delete data
    public function deletedata($tablename, $condition)
    {

        // Build the WHERE part of the UPDATE query
        $whereClause = implode(" AND ", array_map(function ($field, $value) {
            $formattedValue = is_string($value) ? "'" . $this->conn->real_escape_string($value) . "'" : $value;
            return "$field=$formattedValue";
        }, array_keys($condition), $condition));

        // Build the complete UPDATE query
        $qur = "DELETE FROM $tablename WHERE $whereClause";

        // Execute the query
        $get_query_result = $this->conn->query($qur);

        return $get_query_result;
    }

    //select data using join
    public function selectDataWithJoin($mainTable, $joinTable, $joinCondition, $whereValue = [])
    {
        $conditions = [];

        foreach ($whereValue as $field => $value) {
            $formattedValue = is_string($value) ? "'" . $this->conn->real_escape_string($value) . "'" : $value;
            $conditions[] = "$field = $formattedValue";
        }

        $whereClause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : '';

        $qur = "SELECT * FROM $mainTable
            JOIN $joinTable ON $joinCondition
            $whereClause";

        $get_query_result = $this->conn->query($qur);
        return $get_query_result;
    }

    //select data unsing groupby
    public function selectdatawithgroupby($id)
    {
        $query = "SELECT roles.role_name, roles.role_id, GROUP_CONCAT(permissions.permission_name) AS permission_names,
              GROUP_CONCAT(DISTINCT module.module) AS module_names
              FROM user_roles
              JOIN roles ON user_roles.role_id = roles.role_id
              LEFT JOIN role_permissions ON user_roles.role_id = role_permissions.role_id
              LEFT JOIN permissions ON role_permissions.permission_id = permissions.permission_id
              LEFT JOIN module ON permissions.mod_id = module.id
              WHERE user_roles.user_id = $id
              GROUP BY roles.role_id";
               $get_query_result = $this->conn->query($query);
               return $get_query_result;
    }
}
