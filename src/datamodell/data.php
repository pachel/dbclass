<?php
/**
 * Created by PhpStorm.
 * User: toth
 * Date: 23.05.2019
 * Time: 16:13
 */

namespace Pachel;

final class datamodell implements datainterface
{
    private $table;
    private $db;

    /**
     * datamodell constructor.
     * @param $table
     * @param $db
     */
    public function __construct($table, &$db)
    {
        $this->table = $table;
        $this->db = &$db;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function get_all($data = [])
    {
        // TODO: Implement get_all() method.
        return $this->db->select($this->table);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function get_by_id($id)
    {
        // TODO: Implement get_by_id() method.
        return $this->db->select($this->table, ["id" => $id])[0];
    }

    public function get_by_uid($uid)
    {
        // TODO: Implement get_by_uid() method.

    }

    public function get_by_data($data = [])
    {
        // TODO: Implement get_by_data() method.
    }

    /**
     * @param $data
     * @param $id
     */
    public function update($data, $id)
    {
        // TODO: Implement update() method.
        $this->db->update($this->table, $id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        // TODO: Implement insert() method.
        return $this->db->insert($this->table, $data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        // TODO: Implement delete() method.
        return $this->db->delete($this->table, $id);
    }
}