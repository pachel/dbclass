<?php
namespace Pachel\generatedModels;

use \Pachel\dbClass\Callbacks\CallbackBase;
use \Pachel\dbClass\dataModel\dataModel;
use \Pachel\dbClass\dataModel\Traits\EqualMethods;
use \Pachel\dbClass\dataModel\Traits\LikeMethods;

/**
 * @method #classnameDataModel getById(int $id)
 * @method #classnameSelectCBclass select(array|object $where)
 * @method #classnameModelEqualSelect like()
 * @method #classnameModelEqualSelect equal()
 * ...
 * @generated by dbClass #datum
 * @author Tóth László
 * @email pachel82@gmail.com
**/
class #classnameModel extends dataModel{
	/**
	* @var string $_primary A(z) "#table" tábla elsődleges kulcsa az adatbázisban
	*/
	protected $_primary = "#primary";

	/**
	* @var string $_tablename Az SQL tábla neve
	*/
	protected $_tablename = "#table";

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
	protected $_modelclass = #classnameDataModel::class;

	protected $_likeclass = #classnameModelLikeSelect::class;

    protected $_equalclass  = #classnameModelEqualSelect::class;
}
/**
#variables
*/
class #classnameDataModel extends \stdClass{

}

/**
#equalmethods */
class #classnameModelEqualSelect extends CallbackBase {
    use EqualMethods;
}

/**
#likemethods */
class #classnameModelLikeSelect extends CallbackBase {
    use LikeMethods;
}
/**
 * @method #classnameDataModel[] rows()
 * @method #classnameDataModel line()
 * @method mixed simple()
 */
abstract class #classnameSelectCBclass{

}