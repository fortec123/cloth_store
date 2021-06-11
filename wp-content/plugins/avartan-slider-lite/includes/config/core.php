<?php
if (!defined('ABSPATH'))
    exit();

class AvartanSliderLiteCore {

    private $lastRowID;

    /**
     * @since 1.3
     * @param string $message message for error
     * @param integer $code
     * @return string throw error
     */
    private function throwError($message, $code = -1) {
        AvartanSliderLiteFunctions::throwError($message, $code);
    }

    /**
     * Validate for errors
     *
     * @since 1.3
     * @param string $prefix
     */
    private function checkForErrors($prefix = "") {
        global $wpdb;
        if ($wpdb->last_error !== '') {
            $query = $wpdb->last_query;
            $message = $wpdb->last_error;
            if ($prefix)
                $message = $prefix . ' - <b>' . $message . '</b>';
            if ($query)
                $message .= '<br>---<br> '.__('Query', 'avartan-slider-lite').': ' . esc_attr($query);

            $this->throwError($message);
        }
    }

    /**
     * Insert data to table
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $table table name
     * @param array $arrItems
     * @return integer inserted data row id
     */
    public function insert($table, $arrItems) {
        global $wpdb;
        $wpdb->insert($table, $arrItems);
        $this->checkForErrors(__("Insert query error", 'avartan-slider-lite'));
        $this->lastRowID = $wpdb->insert_id;
        return($this->lastRowID);
    }

    /**
     * Get last insert id
     *
     * @since 1.3
     */
    public function getLastInsertID() {
        global $wpdb;
        $this->lastRowID = $wpdb->insert_id;
        return($this->lastRowID);
    }

    /**
     * Delete rows
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $table table name
     * @param string $where where query
     */
    public function delete($table, $where) {
        global $wpdb;
        AvartanSliderLiteFunctions::validateNotEmpty($table, "table name");
        AvartanSliderLiteFunctions::validateNotEmpty($where, "where");
        $query = "delete from $table where $where";
        $wpdb->query($query);
        $this->checkForErrors(__("Delete query error", 'avartan-slider-lite'));
    }

    /**
     * Run sql query
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $query query to run
     */
    public function runSql($query) {
        global $wpdb;
        $wpdb->query($query);
        $this->checkForErrors(__("Regular query error", 'avartan-slider-lite'));
    }

    /**
     * Get data based on query
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $query
     * @param string $format
     * @return object|array
     */
    public function runSqlR($query,$format = OBJECT) {
        global $wpdb;
        $return = $wpdb->get_results($query, $format);
        return $return;
    }

    /**
     * Insert variables to table
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $table table name
     * @param array $arrItems array to update
     * @param string $where
     */
    public function update($table, $arrItems, $where) {
        global $wpdb;
        $response = $wpdb->update($table, $arrItems, $where);
        return($wpdb->num_rows);
    }

    /**
     *  Delete table data
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $table_name table name
     */
    public function truncateTable($table_name){
        global $wpdb;
        $query = "TRUNCATE TABLE $table_name";
        $response = $wpdb->get_var($query);
        $this->checkForErrors("fetch");
        return($response);
    }

    /**
     * Get data array from the database
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $select
     * @param string $from
     * @param string $where
     * @param string $order_by
     * @param string $group_by
     * @param string $extra
     * @param string $format object|array format for result
     * @return object|array $response
     */
    public function fetch($select, $from , $where = "", $order_by = "", $group_by = "", $extra = "", $format = OBJECT) {
        global $wpdb;

        $query = "select $select from $from";
        if ($where)
            $query .= " where $where";
        if ($order_by)
            $query .= " order by $order_by";
        if ($group_by)
            $query .= " group by $group_by";
        if ($extra)
            $query .= " " . $extra;
        $response = $wpdb->get_results($query,$format);
        $this->checkForErrors("fetch");
        return($response);
    }

    /**
     * Get Join data array from the database
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $select
     * @param string $from
     * @param string $leftjoin
     * @param string $on
     * @param string $where
     * @param string $col
     * @param string $order_by
     * @param string $group_by
     * @return array $response
     */
    public function fetchJoinCol($select, $from , $leftjoin , $on , $where = "", $col = false , $order_by = "", $group_by = "") {
        global $wpdb;

        $query = "select $select from $from";
        if ($leftjoin)
            $query .= " LEFT JOIN $leftjoin";
        if ($on)
            $query .= " ON $on";
        if ($where)
            $query .= " where $where";
        if ($order_by)
            $query .= " order by $order_by";
        if ($group_by)
            $query .= " group by $group_by";
        if($col) {
            $response = $wpdb->get_col($wpdb->prepare($query));
        } else {
            $response = $wpdb->get_results($query);
        }

        return($response);
    }

    /**
     * Get row data object from the database
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $select
     * @param string $from
     * @param string $where
     * @return array $response
     */
    public function getRow($select, $from , $where = "") {
        global $wpdb;

        $query = "select $select from $from";
        if ($where)
            $query .= " where $where";

        $response = $wpdb->get_row($query);
        $this->checkForErrors("fetch");
        return($response);
    }

    /**
     * Fetch only one item. if not found - throw error
     *
     * @since 1.3
     * @param string $select
     * @param string $tableName
     * @param string $where
     * @param string $orderField
     * @param string $groupByField
     * @param string $sqlAddon
     * @param string $format
     * @return object|array $record
     */
    public function fetchSingle($select, $tableName, $where = "", $orderField = "", $groupByField = "", $sqlAddon = "",$format = OBJECT) {
        $response = $this->fetch($select, $tableName, $where, $orderField, $groupByField, $sqlAddon,$format);

        if (empty($response))
            $this->throwError(__("Record not found", 'avartan-slider-lite'));
        $record = $response[0];
        return($record);
    }

    /**
     * Prepare statement to avoid sql injections
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $query
     * @param array $array
     * @return array $query
     */
    public function prepare($query, $array) {
        global $wpdb;
        $query = $wpdb->prepare($query, $array);
        return($query);
    }

    /**
     * Delete table
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $table_name
     */
    public function dropTbl($table_name) {
        global $wpdb;
        $sql = 'DROP TABLE ' . $table_name . ';';
        $wpdb->query($sql);
    }

    /**
     * Create table slider
     *
     * @since 1.3
     * @global object $wpdb
     */
    public function createSliderTbl() {
        global $wpdb;
        $table_name = avsLiteGlobals::$avs_slider_tbl;
        $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name TEXT CHARACTER SET utf8,
        alias TEXT CHARACTER SET utf8,
        slider_option LONGTEXT CHARACTER SET utf8,
        UNIQUE KEY id (id)
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Create table slides
     *
     * @since 1.3
     * @global object $wpdb
     */
    public function createSlidesTbl() {
        global $wpdb;
        $table_name = avsLiteGlobals::$avs_slides_tbl;
        $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        slider_parent mediumint(9),
        position INT,
        params LONGTEXT CHARACTER SET utf8,
        layers LONGTEXT CHARACTER SET utf8,
        UNIQUE KEY id (id)
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }  
    
    /**
     * Create table preset
     *
     * @since 1.4
     * @global object $wpdb
     */
    public function createPresetTbl() {
        global $wpdb;
        $table_name = avsLiteGlobals::$avs_preset_tbl;
        $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        title mediumtext CHARACTER SET utf8,
        image LONGTEXT CHARACTER SET utf8,
        type mediumtext CHARACTER SET utf8,
        params LONGTEXT CHARACTER SET utf8,
        layers LONGTEXT CHARACTER SET utf8,
        UNIQUE KEY id (id)
        );";
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    /**
     * Alter table
     *
     * @since 1.3
     * @global object $wpdb
     */
    public function alterSlidesTbl() {
        global $wpdb;
        $table_name = avsLiteGlobals::$avs_slides_tbl;
        $fieldname = "visibility";
        if($wpdb->get_var("SHOW COLUMNS FROM ".$table_name." LIKE '".$fieldname."'") != $fieldname) {
            $sql = "ALTER TABLE $table_name ADD visibility BOOLEAN NOT NULL DEFAULT TRUE COMMENT '1=Visible, 0=Unvisible' AFTER position;";
            $wpdb->query($sql);
        }
    }

    /**
     * Count total number of rows
     *
     * @since 1.3
     * @global object $wpdb
     * @param string $table_name
     * @param string $where
     * @return array $response
     */
    public function countTotalData($table_name,$where='') {
        global $wpdb;
        $query = "SELECT COUNT(*) FROM $table_name";
        if($where != '')
            $query .= " WHERE $where";
        $response = $wpdb->get_var($query);
        $this->checkForErrors("fetch");
        return($response);
    }

}