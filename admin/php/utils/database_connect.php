<?php
    class DatabaseConfig {
        private $envPath;
        private $env;
        private $servername;
        private $username;
        private $password;
        private $database;

        public function __construct() {
        // Connect to the database
            $this->envPath = __DIR__ . '/../../.env';
            $this->env = parse_ini_file($this->envPath);

        // Get credentials from .env file
            $this->servername = $this->env['DB_HOST'];
            $this->username = $this->env['DB_USER'];
            $this->password = $this->env['DB_PASSWORD'];
            $this->database = $this->env['DB_NAME'];
        }

    // Getter methods to access private properties
        public function getServername() {
            return $this->servername;
        }

        public function getUsername() {
            return $this->username;
        }

        public function getPassword() {
            return $this->password;
        }

        public function getDatabase() {
            return $this->database;
        }
}

// Create a new instance of DatabaseConfig
    $con = new DatabaseConfig();

// Use getter methods to retrieve the credentials
    $database_connection = mysqli_connect(
        $con->getServername(),
        $con->getUsername(),
        $con->getPassword(),
        $con->getDatabase()
    );

// Check connection
    if (!$database_connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // echo "Connected successfully!";
?>