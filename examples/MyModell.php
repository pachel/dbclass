<?php
class MyModell extends BaseModell
{

    protected string $userDefinedType = "UserType";
    protected $SearchableFields = "all";
    /**
     * @param $id
     * @return UserType
     */
    public function find($id)
    {
        return parent::find($id); // TODO: Change the autogenerated stub
    }
    public function __construct($db, $table)
    {
        parent::__construct($db, $table);

    }

    protected function h(){
        $t = $this->find(1);

    }
}