<?php
use \Pachel\dbClass\Callbacks\CallbackBase;
use \Pachel\dbClass\dataModel\dataModel;
use \Pachel\dbClass\dataModel\Traits\EqualMethods;
use \Pachel\dbClass\dataModel\Traits\LikeMethods;

/**
 * @method __usersDataModel getById(int $id)
 * @method __usersSelectCBclass select(array|object $where)
 * @method __usersModelEqualSelect like()
 * @method __usersModelEqualSelect equal()
 * ...
 * @generated by dbClass 2023-12-14 22:05
 * @author Tóth László
 * @email pachel82@gmail.com
 **/
class __usersModel extends dataModel{
    /**
     * @var string $_primary A(z) "__users" tábla elsődleges kulcsa az adatbázisban
     */
    protected $_primary = "id";

    /**
     * @var string $_tablename Az SQL tábla neve
     */
    protected $_tablename = "__users";

    /**
     * @var array $_not_visibles A SELECT lekérdezésben láthatatlan mezők nevei
     */
    protected $_not_visibles = [];

    /**
     * @var bool $_safemode Biztonságos mód a törléshez, ha ez true, akkor a mezőt is be kell állítani
     */
    protected $_safemode = false;

    /**
     * @var string $_safefield A törléshez használt mező, ami a biztonságos törlésnél 1-es értéket vesz fel
     */
    protected $_safefield = "deleted";
    //Az adatmodel osztály neve
    protected $_modelclass = __usersDataModel::class;

    protected $_likeclass = __usersModelLikeSelect::class;

    protected $_equalclass  = __usersModelEqualSelect::class;
}
class __usersDataModel{
    /**
     * Primary ID ----------------------------------------
     * @var int $id;
     **/
    public $id;
    /**
     * @var string $name;
     **/
    public $name;
    /**
     * @var int $type;
     **/
    public $type;
    /**
     * @var string $email;
     **/
    public $email;
    /**
     * @var string $inserted;
     **/
    public $inserted;

}

/**
 * @method __usersDataModel[] id(int $id)
 * @method __usersDataModel[] name(string $name)
 * @method __usersDataModel[] type(int $type)
 * @method __usersDataModel[] email(string $email)
 * @method __usersDataModel[] inserted(string $inserted)
 */
class __usersModelEqualSelect extends CallbackBase {
    use EqualMethods;
}

/**
 * @method __usersDataModel[] name(string $name)
 * @method __usersDataModel[] email(string $email)
 * @method __usersDataModel[] inserted(string $inserted)
 */
class __usersModelLikeSelect extends CallbackBase {
    use LikeMethods;
}

/**
 * @method __usersDataModel[] rows()
 * @method __usersDataModel line()
 * @method mixed simple()
 */
abstract class __usersSelectCBclass{

}