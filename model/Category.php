<?php
include $_SERVER['DOCUMENT_ROOT'].'/DatabaseConnection.php';

class Category
{
    private $id;
    private $name;

    /**
     * Category constructor.
     * @param $id
     * @param $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }


    public static function getAll(){
        $list = [];
        $db = DatabaseConnection::getInstance();
        $req = $db->query('SELECT * FROM category');

        foreach($req->fetchAll() as $category) {
            $list[] = new Category($category['ID'], $category['NAME']);
        }

        return $list;
    }

    public static function getId($name){
        $db = DatabaseConnection::getInstance();

        if($req=$db->query("SELECT ID FROM category WHERE NAME='$name'")){
            $res= $req->fetch(PDO::FETCH_ASSOC);
            return $res['ID'];
        }
    }

    public static function getNameByID($id){
        $db = DatabaseConnection::getInstance();

        if($req=$db->query("SELECT NAME FROM category WHERE ID='$id'")){
            $res= $req->fetch(PDO::FETCH_ASSOC);
            return $res['NAME'];
        }
    }

    public function getOneCategory(){}

    public function __toString()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }



}