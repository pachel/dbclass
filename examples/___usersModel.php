<?php
namespace Pachel\generatedModels;

use \Pachel\dbClass\Callbacks\CallbackBase;
use \Pachel\dbClass\dataModel\dataModel;
use \Pachel\dbClass\dataModel\Traits\EqualMethods;
use \Pachel\dbClass\dataModel\Traits\EqMethods;
use \Pachel\dbClass\dataModel\Traits\LikeMethods;
use \Pachel\dbClass\dataModel\Traits\UpMethods;

/**
 * @method __usersDataModel getById(int $id)
 * @method __usersSelectCBclass select(array|object $where)
 * @method __usersModelEqualSelect like()
 * @method __usersModelEqualSelect equal()
 * @method __usersModelEqSelect eq()
 * asda sd haskl dalksdjlaksjd lkasd
 * @method __usersModelUpSelect up()
 * ...
 * @generated by dbClass 2024-09-13 07:12
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

    protected $_eqclass  = __usersModelEqSelect::class;

    protected $_upclass  = __usersModelUpSelect::class;
}
/**
 * Primary ID ----------------------------------------
 * @property int $id
 * @property string $name
 * @property int $type
 * @property string $email
 * @property string $inserted

*/
class __usersDataModel extends \stdClass{

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
 * @method __usersDataModel[] rows()
 * @method __usersDataModel line()
 * @method mixed simple()
 * @method __usersModelEqSelect id(int $id)
 * @method __usersModelEqSelect name(string $name)
 * @method __usersModelEqSelect type(int $type)
 * @method __usersModelEqSelect email(string $email)
 * @method __usersModelEqSelect inserted(string $inserted)
 */
class __usersModelEqSelect extends CallbackBase {
    use EqMethods;
}
/**

 * @method mixed exec()
 * @method __usersModelUpSelect where()
 * @method __usersModelUpSelect id(int $id)
 * @method __usersModelUpSelect name(string $name)
 * @method __usersModelUpSelect type(int $type)
 * @method __usersModelUpSelect email(string $email)
 * @method __usersModelUpSelect inserted(string $inserted)
 */
class __usersModelUpSelect extends CallbackBase {
    use UpMethods;
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