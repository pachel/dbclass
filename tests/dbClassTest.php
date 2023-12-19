<?php

use Pachel\dbClass;
use PHPUnit\Framework\TestCase;

/**
 * @property dbClass $db
 */
class dbClassTest extends TestCase
{

    protected function newUserData($array = true){
        $nev = md5(time().microtime());
        if($array)
            return ["name"=>$nev,"type"=>10];
        $d = new \stdClass();
        $d->name = $nev;
        $d->type = 10;
        return $d;
    }
    protected function setUp(): void
    {
        require __DIR__ . "/../examples/inc/dev_config.php";
        $db = new dbClass();
        $db->settings()->connect($db_config, $db_options);
        $this->db = $db;
    }

    /**
     * @covers \SebastianBergmann\Complexity\Calculator
     * @return void
     */
    public function test_setResultMode()
    {

        $user = $this->db->query("SELECT *FROM __users")->line();
        $isObject = is_object($user);
        $this->assertTrue($isObject, "Alapértelmezett mód a tesztben DB_RESULT_TYPE_OBJECT");

        $this->db->settings()->setResultmodeToArray();
        $user = $this->db->query("SELECT *FROM __users")->line();
        $isObject = is_array($user);
        $this->assertTrue($isObject, "Visszatérési érték mód átállítva: DB_RESULT_TYPE_ARRAY");

        $this->db->settings()->setResultmodeToObject();
        $user = $this->db->query("SELECT *FROM __users")->line();
        $isObject = is_object($user);
        $this->assertTrue($isObject, "Visszatérési érték mód átállítva: DB_RESULT_TYPE_OBJECT");
    }

    /**
     * @covers
     * @return void
     */
    public function test_setDefaultResultMode()
    {
        $this->db->settings()->setResultmodeToArray();
        $user = $this->db->query("SELECT *FROM __users")->line();
        $this->assertTrue(is_array($user),"Mód: DB_RESULT_TYPE_ARRAY");

        $this->db->settings()->setResultmodeToDefault();
        $user = $this->db->query("SELECT *FROM __users")->line();
        $this->assertTrue(is_object($user),"Alapértelmezettre állítva: DB_RESULT_TYPE_OBJECT");

        $this->db->settings()->setDefaultResultMode(dbClass::DB_RESULT_TYPE_ARRAY);
        $user = $this->db->query("SELECT *FROM __users")->line();
        $this->assertTrue(is_array($user),"DEFAULT átállítva: DB_RESULT_TYPE_ARRAY");

        $this->db->settings()->setResultmodeToObject();
        $user = $this->db->query("SELECT *FROM __users")->line();
        $this->assertTrue(is_object($user),"Átállítva: DB_RESULT_TYPE_OBJECT");

        $this->db->settings()->setDefaultResultMode(dbClass::DB_RESULT_TYPE_OBJECT);
        $user = $this->db->query("SELECT *FROM __users")->line();
        $this->assertTrue(is_object($user),"DEFAUTL visszaállítva: DB_RESULT_TYPE_OBJECT");
    }

    /**
     * @covers
     * @return void
     * @throws Exception
     */
    public function test_Insert(){
        $data = $this->newUserData();
        $res = $this->db->insert("__users",$data);
        $this->assertTrue($res,"INSERT INTO");
        $id = $this->db->last_insert_id();
        $this->assertTrue(is_numeric($id),"LAST INSERT ID");
        $user = $this->db->query("SELECT name FROM __users WHERE id=?")->params($id)->line();
        $this->assertEquals($data["name"],$user->name,"Új felhasználó beillesztése");
    }

    /**
     * @covers
     * @return void
     * @throws Exception
     */
    public function test_Update(){
        $nev = md5(time().microtime());
        $data = ["name"=>$nev,"type"=>10];
        $res = $this->db->insert("__users",$data);
        $id = $this->db->last_insert_id();
        $nev = md5(time().microtime());
        $data = ["name"=>$nev];
        $this->db->update("__users",$data,["id"=>$id]);
        $user = $this->db->query("SELECT name FROM __users WHERE id=?")->params($id)->simple();
        $this->assertEquals($user,$nev,"UPDATE Tömb paraméterrel");

        $nev = md5(time().microtime());
        $data = new \stdClass();
        $data->name = $nev;
        $this->db->update("__users",$data,["id"=>$id]);
        $user = $this->db->query("SELECT name FROM __users WHERE id=?")->params($id)->simple();
        $this->assertEquals($user,$nev,"UPDATE Objektum paraméterrel");

        $nev = md5(time().microtime());
        $where = new \stdClass();
        $where->id=$id;
        $data = new \stdClass();
        $data->name = $nev;
        $this->db->update("__users",$data,$where);
        $user = $this->db->query("SELECT name FROM __users WHERE id=:id")->params($where)->simple();
        $this->assertEquals($user,$nev,"UPDATE Objektum paraméterrel és objektum feltétellel");
    }
}