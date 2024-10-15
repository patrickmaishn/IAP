<?php
class dbConnection {
    private $connection;
    private $db_type;
    private $db_host;
    private $db_port;
    private $db_user;
    private $db_pass;
    private $db_name;

    public function __construct($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name) {
        $this->db_type = $db_type;
        $this->db_host = $db_host;
        $this->db_port = $db_port;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
        
        $this->connection($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name);
    }

    public function connection($db_type, $db_host, $db_port, $db_user, $db_pass, $db_name) {
        switch ($db_type) {
            case 'PDO':
                if ($db_port !== null) {
                    $db_host .= ":" . $db_port;
                }
                try {
                    $this->connection = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
                    $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die("Connection failed: " . $e->getMessage());  // Stop execution on failure
                }
                break;

            case 'MySQLi':
                if ($db_port !== null) {
                    $db_host .= ":" . $db_port;
                }
                $this->connection = new mysqli($db_host, $db_user, $db_pass, $db_name);
                if ($this->connection->connect_error) {
                    die("Connection failed: " . $this->connection->connect_error);  // Stop execution on failure
                }
                break;
        }
    }

    public function escape_values($posted_values): string {
        if ($this->connection === null) {
            die("Database connection not established.");
        }

        switch ($this->db_type) {
            case 'PDO':
                return addslashes($posted_values);
            case 'MySQLi':
                return $this->connection->real_escape_string($posted_values);
        }
    }

    public function count_results($sql) {
        if ($this->connection === null) {
            die("Database connection not established.");
        }

        switch ($this->db_type) {
            case 'PDO':
                $res = $this->connection->prepare($sql);
                $res->execute();
                return $res->rowCount();
            case 'MySQLi':
                $result = $this->connection->query($sql);
                if (is_object($result)) {
                    return $result->num_rows;
                } else {
                    print "Error: " . $sql . "<br />" . $this->connection->error . "<br />";
                }
        }
    }

    public function insert($table, $data) {
        ksort($data);
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = implode("', '", array_values($data));
        $sth = "INSERT INTO $table (`$fieldNames`) VALUES ('$fieldValues')";
        return $this->extracted($sth);
    }

    public function select($sql) {
        if ($this->connection === null) {
            die("Database connection not established.");
        }

        switch ($this->db_type) {
            case 'PDO':
                $result = $this->connection->prepare($sql);
                $result->execute();
                return $result->fetchAll(PDO::FETCH_ASSOC)[0];
            case 'MySQLi':
                $result = $this->connection->query($sql);
                return $result->fetch_assoc();
        }
    }

    public function select_while($sql) {
        if ($this->connection === null) {
            die("Database connection not established.");
        }

        switch ($this->db_type) {
            case 'PDO':
                $result = $this->connection->prepare($sql);
                $result->execute();
                return $result->fetchAll(PDO::FETCH_ASSOC);
            case 'MySQLi':
                $result = $this->connection->query($sql);
                for ($res = []; $row = $result->fetch_assoc(); $res[] = $row);
                return $res;
        }
    }

    public function update($table, $data, $where) {
        if ($this->connection === null) {
            die("Database connection not established.");
        }

        ksort($data);
        $fieldDetails = implode(', ', array_map(fn($k, $v) => "$k='$v'", array_keys($data), $data));
        $whereClause = implode(' AND ', array_map(fn($k, $v) => "$k='$v'", array_keys($where), $where));
        $sth = "UPDATE $table SET $fieldDetails WHERE $whereClause";
        return $this->extracted($sth);
    }

    public function delete($table, $where) {
        if ($this->connection === null) {
            die("Database connection not established.");
        }

        $whereClause = implode(' AND ', array_map(fn($k, $v) => "$k='$v'", array_keys($where), $where));
        $sth = "DELETE FROM $table WHERE $whereClause";
        return $this->extracted($sth);
    }

    public function truncate($table) {
        if ($this->connection === null) {
            die("Database connection not established.");
        }

        $sth = "TRUNCATE $table";
        return $this->extracted($sth);
    }

    public function last_id() {
        if ($this->connection === null) {
            die("Database connection not established.");
        }

        switch ($this->db_type) {
            case 'PDO':
                return $this->connection->lastInsertId();
            case 'MySQLi':
                return $this->connection->insert_id;
        }
    }

    public function extracted(string $sth) {
        if ($this->connection === null) {
            die("Database connection not established.");
        }

        switch ($this->db_type) {
            case 'PDO':
                try {
                    $stmt = $this->connection->prepare($sth);
                    $stmt->execute();
                    return true;
                } catch (PDOException $e) {
                    return $sth . "<br>" . $e->getMessage();
                }
            case 'MySQLi':
                if ($this->connection->query($sth) === true) {
                    return true;
                } else {
                    return "Error: " . $sth . "<br>" . $this->connection->error;
                }
        }
    }
}
