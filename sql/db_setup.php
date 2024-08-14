<?php
session_start();
define('DB_SERVER','localhost');
define('DB_USER','phpmyadmin');
define('DB_PASS' ,'tiger123');
define('DB_NAME', 'tile1');

class DBconnection {
    public $dbh;

    function __construct() {
       
        $this->dbh = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

        // Check connection
        if (mysqli_connect_errno()) {
            throw new Exception("Failed to connect to MySQL: " . mysqli_connect_error());
        }
    }

    public function executeSQLFile($filePath) {
        // Read the SQL file
        $sql = file_get_contents($filePath);

        if ($sql === false) {
            throw new Exception("Could not read SQL file: $filePath");
        }

        // Execute the SQL file
        if (mysqli_multi_query($this->dbh, $sql)) {
            do {
                // Flush multi_queries
                if ($result = mysqli_store_result($this->dbh)) {
                    mysqli_free_result($result);
                }
            } while (mysqli_next_result($this->dbh));
        } else {
            throw new Exception("Error executing SQL file: " . mysqli_error($this->dbh));
        }
    }
}

try {
    $connection = new DBconnection();
    $connection->executeSQLFile('tables.sql');
    echo "Tables created successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
