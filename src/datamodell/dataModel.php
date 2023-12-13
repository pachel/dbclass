<?php
/**
 * Created by PhpStorm.
 * User: toth
 * Date: 23.05.2019
 * Time: 16:13
 */

namespace Pachel\dbClass\dataModel;

use Pachel\dbClass;

abstract class dataModel
{
    /**
     *
     * @var string|null $_tablename
     */
    protected  $_tablename = "";
    /**
     *
     * @var string $_primary
     */
    protected  $_primary = "id";
    /**
     * A SELECT lekérdezésben láthatatlan mezők nevei
     * @var array $_not_visibles
     */
    protected  $_not_visibles = [];

    protected  $_classname = dataModel::class;
    protected  $_modelclass = "";

    /**
     *
     * @var string $_safefield
     */
    protected $_safefield = null;
    /**
     * @var bool $_safemode
     */
    protected $_safemode = false;

    /**
     * @var dbClass $db
     */
    protected  $db;


    public function __construct(&$db = null)
    {
        if (empty($this->_tablename)) {
            $this->_tablename = $this->setTableName(get_called_class());
        }
        $this->_classname = get_called_class();
        if($db != null) {
            $this->db = &$db;
        }
    }
    /**
     *
     * @param string $class
     * @return string $table_name
     * @throws \Exception
     */
    private function setTableName(string $class): string
    {

        if (preg_match("/([^\\\]+)_Model$/", $class, $preg)) {
            $class = $preg[1];
        } else {
            throw new \Exception("Error:");
        }
        return $class;
    }

    /**
     * Select only one row from this table
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->db->query("SELECT *FROM `".$this->_tablename."` WHERE `".$this->_primary."`=?")->params($id)->line();
    }

    /**
     * @param $data
     * @param $id
     */
    public function updateById($data, $id)
    {
        $this->db->update($this->table,$data, [$this->_primary=>$id]);
    }

    /**
     * @param $data
     */
    public function insert($data)
    {
        return $this->db->insert($this->_tablename, $data);
    }

    /**
     * @param $id
     */
    public function deleteById($id)
    {
        return $this->db->delete($this->_tablename, [$this->_primary=>$id]);
    }
}