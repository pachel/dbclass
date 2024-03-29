<?php

use Pachel\dbClass\dataModel\dataModel;
/**
 * @method dolgozokDataModel getById(int $id)
 * @method dolgozokDataModel[] select(array|object $where)
 * @method dolgozokDataModel[] tipus(int $tipus)
 * @method dolgozokDataModel[] id_csoportok(int $tipus)
 * @method dolgozokDataModel[] sorszam(int $tipus)
 *
 * @generated by dbClass 2023-12-14 18:35
 * @author Tóth László
 * @email pachel82@gmail.com
**/
class dolgozokModel extends dataModel{
	/**
	* @var string $_primary A(z) "dolgozok" tábla elsődleges kulcsa az adatbázisban
	*/
	protected $_primary = "id";

	/**
	* @var string $_tablename Az SQL tábla neve
	*/
	protected $_tablename = "dolgozok";

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
	protected $_modelclass = dolgozokDataModel::class;
}
class dolgozokDataModel{
	/**
	* Primary ID ----------------------------------------
	* @var int $id;
	**/
	public $id;
	/**
	* @var int $aktiv;
	**/
	public $aktiv;
	/**
	* @var int $tipus;
	**/
	public $tipus;
	/**
	* @var int $atirt;
	**/
	public $atirt;
	/**
	* @var string $nev;
	**/
	public $nev;
	/**
	* @var int $id_csoportok;
	**/
	public $id_csoportok;
	/**
	* @var int $sorszam;
	**/
	public $sorszam;

}