<?php

/*
 * Database Class
 */

Class DbClass {
    /*
     * @var string DataBase Name
     */

    protected $dbname;
    /*
     * @var string DataBase Host
     */
    protected $dbhost;
    /*
     * @var string DataBase User
     */
    protected $dbuser;
    /*
     * @var string Database Password
     */
    protected $dbpass;
    /*
     * @var boolean is db conection is available
     */
    protected $is_connected = false;
    /*
     * @var resporce DataBase Connection
     */
    protected $conn;
    /*
     * @var object contains the query result set
     */
    public $resultSet;
    /*
     * @var boolean logEnable
     */
    private $logEnable = true;
    /*
     * @var Hold the sql query
     */
    public $sql_query;
    /*
     * Log file name
     */
    private $log_file;

    /*
     * initailize the db connection
     */

    public function __construct($db_host, $db_user, $db_pass, $db_name) {

        $this->dbhost = $db_host;
        $this->dbuser = $db_user;
        $this->dbpass = $db_pass;
        $this->dbname = $db_name;

        if ($this->is_connected === false) {
            $this->connectDb();
        }
    }

    /*
     *  Connect to Db and if connection successful set is_connected is true
     */

    private function connectDb() {

        if ($this->conn = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname)) {
            $this->setLogFile();
            $this->set_connected(true);
            $this->createTable();
        } else {
            die('Could not select database ' . mysqli_connect_error() . '. Please check connection parameters in includes/config.php');
        }
    }

    /*
     * @ iinput is boolean
     * Set is_connected  =  true
     */

    private function set_connected($boolean) {
        if ($boolean === true) {
            $this->is_connected = true;
        } else {
            $this->is_connected = false;
        }
    }

    /*
     * Check if database connection is already is set or not
     */

    public function is_connected() {
        if ($this->is_connected === true) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * close Db connection
     */

    public function closeDB() {
        if ($this->is_connected === true) {
            if (@mysqli_close($this->conn)) {
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /*
     * run query
     * this will return the result
     */

    public function runQuery() {
        if ($this->resultSet = @mysqli_query($this->conn, $this->sql_query)) {
            return $this->resultSet;
        } else {
            $this->logDBError();
        }
    }

    /*
     * Execute the query
     * User ful for insert/update/delete    
     */

    public function executeQuery() {
        if (!$this->resultSet = @mysqli_query($this->conn, $this->sql_query)) {
            $this->logDBError();
        }
    }

    /*
     * Get One record as an array
     */

    public function fecthData() {
        $data = $this->runQuery();
        $record = @mysqli_fetch_assoc($data);
        $this->freeResult($data);
        return $record;
    }

    /*
     *  Gell all records
     */

    public function fetchAllData() {
        $data = $this->runQuery();        
        while($row = @mysqli_fetch_assoc($data)) {
            $record_array[] = $row;
        }
        $this->freeResult($data);
        return $record_array;
    }

    /*
     *  get num rows
     */

    public function getDbNumRows() {
        if ($this->resultSet) {
            return mysqli_num_rows($this->resultSet);
        } else {
            return '0';
        }
    }

    /*
     * Gte afftected number of rows
     */

    public function getAfftectedRows() {
        if ($this->resultSet) {
            return mysqli_affected_rows($this->conn);
        } else {
            return '0';
        }
    }

    /*
     *  parse the data
     */

    public function parseSqlData($str) {
        return mysqli_escape_string($this->conn, $str); 
    }

    /*
     * Set log file path
     */

    public function setLogFile() {
        $this->log_file = __DIR__ . "../db_error.log";
    }

    /*
     * Log the Db errors
     */

    private function logDBError() {
        if ($this->logEnable === true) {
            // Enter query in log file
            $fs_logfile = fopen($this->log_file, "a+");
            fwrite($fs_logfile, date("Y-m-d H:i:s") . "-" . $this->sql_query);
            fwrite($fs_logfile, "\n");
            fwrite($fs_logfile, @mysqli_error($this->conn));
            fwrite($fs_logfile, "\n");
            fclose($fs_logfile);
        }
    }

    /*
     * Create table     
     */

    private function createTable() {

        $this->sql_query = "CREATE TABLE IF NOT EXISTS `" . DB_TABLE . "` (
                                    `order_id` int(11) NOT NULL AUTO_INCREMENT,
                                    `customer_name` varchar(255) NOT NULL,
                                    `card_holder_name` varchar(255) NOT NULL,
                                    `card_number` varchar(20) NOT NULL,
                                    `card_type` varchar(25) NOT NULL,
                                    `card_expiry` varchar(10) NOT NULL,
                                    `card_cvv` varchar(4) NOT NULL,
                                    `payment_currency` varchar(3) NOT NULL,
                                    `payment_gateway` varchar(25) NOT NULL,
                                    `transaction_id` varchar(50) DEFAULT NULL,
                                    `order_status` varchar(20) DEFAULT NULL,
                                    `order_amount` varchar(20) DEFAULT NULL,
                                    `order_created_time` datetime DEFAULT NULL,
                                    `transaction_response` text NOT NULL,
                                    PRIMARY KEY (`order_id`)
                                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        $this->executeQuery($this->conn);
    }

    /*
     * Get latest insert id
     */

    public function getInsertID() {
        return @mysqli_insert_id($this->conn);
    }
    /*
     * Free the result set
     */
    private function freeResult($param) {
        @mysql_free_result($param);
    }

}

?>