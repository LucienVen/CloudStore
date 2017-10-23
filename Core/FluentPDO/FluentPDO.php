<?php
/**
 * FluentPDO is simple and smart SQL query builder for PDO
 *
 * For more information @see readme.md
 *
 * @link      http://github.com/lichtner/fluentpdo
 * @author    Marek Lichtner, marek@licht.sk
 * @copyright 2012 Marek Lichtner
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */

include_once 'FluentStructure.php';
include_once 'FluentUtils.php';
include_once 'FluentLiteral.php';
include_once 'BaseQuery.php';
include_once 'CommonQuery.php';
include_once 'SelectQuery.php';
include_once 'InsertQuery.php';
include_once 'UpdateQuery.php';
include_once 'DeleteQuery.php';

/**
 * Class FluentPDO
 */
class FluentPDO
{

    /** @var \PDO */
    public $pdo;
    /** @var \FluentStructure|null */
    protected $structure;

    /** @var bool|callback */
    public $debug;

    /** @var string */
    public $table;

    /** @var string */
    public $oldTable;

    /** @var array */
    public $field;

    /**
     * FluentPDO constructor.
     *
     * @param \PDO                  $pdo
     * @param \FluentStructure|null $structure
     */
    function __construct($db, FluentStructure $structure = null) {
        $this->pdo = new \PDO('mysql:host='.$db['host'].';dbname='.$db['dbname'], $db['user'], $db['pass']);
        // set error format
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (!$structure) {
            $structure = new FluentStructure();
        }
        $this->structure = $structure;
        $reflection = new \ReflectionClass($this);
        $this->oldTable = $db['prefix'] . strtolower(trim($reflection->getShortName()));
        $this->table = $this->oldTable;
        $this->field = $this->pdo->query("DESC `" . $this->table . "`")->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Create SELECT query from $table
     *
     * @param string  $table      - db table name
     * @param integer $primaryKey - return one row by primary key
     *
     * @return \SelectQuery
     */
    public function from($table = '', $primaryKey = null) {
        $this->table = $table ? $table : $this->oldTable;
        $query = new SelectQuery($this, $this->table);
        if ($primaryKey !== null) {
            $tableTable     = $query->getFromTable();
            $tableAlias     = $query->getFromAlias();
            $primaryKeyName = $this->structure->getPrimaryKey($tableTable);
            $query          = $query->where("$tableAlias.$primaryKeyName", $primaryKey);
        }

        return $query;
    }

    /**
     * Create INSERT INTO query
     *
     * @param string $table
     * @param array  $values - accepts one or multiple rows, @see docs
     *
     * @return \InsertQuery
     */
    public function insertInto($table = '', $values = array()) {
        $this->table = $table ? $table : $this->oldTable;
        $query = new InsertQuery($this, $this->table, $values);

        return $query;
    }

    /**
     * Create UPDATE query
     *
     * @param string       $table
     * @param array|string $set
     * @param string       $primaryKey
     *
     * @return \UpdateQuery
     */
    public function update($table = '', $set = array(), $primaryKey = null) {
        $this->table = $table ? $table : $this->oldTable;
        $query = new UpdateQuery($this, $this->table);
        $query->set($set);
        if ($primaryKey) {
            $primaryKeyName = $this->getStructure()->getPrimaryKey($table);
            $query          = $query->where($primaryKeyName, $primaryKey);
        }

        return $query;
    }

    /**
     * Create DELETE query
     *
     * @param string $table
     * @param string $primaryKey delete only row by primary key
     *
     * @return \DeleteQuery
     */
    public function delete($table = '', $primaryKey = null) {
        $this->table = $table ? $table : $this->oldTable;
        $query = new DeleteQuery($this, $this->table);
        if ($primaryKey) {
            $primaryKeyName = $this->getStructure()->getPrimaryKey($table);
            $query          = $query->where($primaryKeyName, $primaryKey);
        }

        return $query;
    }

    /**
     * Create DELETE FROM query
     *
     * @param string $table
     * @param string $primaryKey
     *
     * @return \DeleteQuery
     */
    public function deleteFrom($table = '', $primaryKey = null) {
        $this->table = $table ? $table : $this->oldTable;
        $args = func_get_args();

        return call_user_func_array(array($this, 'delete'), $args);
    }

    /**
     * @return \PDO
     */
    public function getPdo() {
        return $this->pdo;
    }

    /**
     * @return \FluentStructure
     */
    public function getStructure() {
        return $this->structure;
    }

    /**
     * Closes the \PDO connection to the database
     *
     * @return null
     */
    public function close() {
        $this->pdo = null;
    }

    /**
     * get table all field name
     *
     * @return array
     */
    public function getField() {
        return $this->field;
    }

    /**
     * filte the disabled field
     *
     * @param boolean $field
     * @return void
     */
    // public function field($field = true) {
    // }

}
