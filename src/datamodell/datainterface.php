<?php
/**
 * Created by PhpStorm.
 * User: toth
 * Date: 23.05.2019
 * Time: 16:50
 */

namespace Pachel;

interface datainterface{
    public function get_all($data = []);
    public function get_by_data($data = []);
    public function get_by_id($id);
    public function get_by_uid($uid);
    public function update($data,$id);
    public function insert($data);
    public function delete($id);
}