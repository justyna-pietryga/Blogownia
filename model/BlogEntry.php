<?php

/**
 * Created by PhpStorm.
 * User: Justyna
 * Date: 2017-12-14
 * Time: 22:39
 */

class BlogEntry
{
    private $id;
    private $user_id;
    private $date;
    private $title;
    private $content;
    private $category_id;
    private $category;

    /**
 * BlogEntry constructor.
 * @param $id
 * @param $user_id
 * @param $date
 * @param $title
 * @param $content
 * @param $category_id
 * @param $category
 */

    public function __construct($id, $user_id, $date, $title, $content, $category_id)
{
    $this->id = $id;
    $this->user_id = $user_id;
    $this->date = $date;
    $this->title = $title;
    $this->content = $content;
    $this->category_id = $category_id;
}



    public static function getAll($login_id){
        $list = [];
        $db = DatabaseConnection::getInstance();
        $req = $db->query("SELECT * FROM blog_entry WHERE USER_ID=".$login_id." ORDER BY ID DESC");

        foreach($req->fetchAll() as $post) {
            $list[] = new BlogEntry($post['ID'], $post['USER_ID'], $post['ADDING_DATE'], $post['TITLE'], $post['CONTENT'], $post['CATEGORY_ID']);
        }

        return $list;
    }

    public static function getTheBest(){

        $loginID = 0;
        if(isset($_SESSION['login'])) $loginID=Account::getId($_SESSION['login']);

        $list=[];
        $db = DatabaseConnection::getInstance();
        $req= $db->query("SELECT B.ID AS id, B.USER_ID AS us_id, B.ADDING_DATE AS ad_dt, B.CONTENT AS con, B.TITLE AS tit, B.CATEGORY_ID AS cat, COUNT(*) FROM blog_entry AS B INNER JOIN liking AS L ON L.BLOG_ENTRY_ID=B.ID WHERE B.USER_ID !=".$loginID." GROUP BY L.BLOG_ENTRY_ID ORDER BY COUNT(*) DESC");

        foreach($req->fetchAll(PDO::FETCH_ASSOC) as $post) {
            $list[] = new BlogEntry($post['id'], $post['us_id'], $post['ad_dt'], $post['tit'], $post['con'], $post['cat']);
        }

        return $list;
    }

    public static function getAllByCategory($category_id){
        $list = [];
        $db = DatabaseConnection::getInstance();
        $req = $db->query("SELECT * FROM blog_entry WHERE CATEGORY_ID=".$category_id." ORDER BY ID DESC");

        foreach($req->fetchAll() as $post) {
            $list[] = new BlogEntry($post['ID'], $post['USER_ID'], $post['ADDING_DATE'], $post['TITLE'], $post['CONTENT'], $post['CATEGORY_ID']);
        }

        return $list;
    }

    public static function getOnePost($postId){
        $db = DatabaseConnection::getInstance();
        $sql= "SELECT * FROM blog_entry WHERE ID='".$postId."'";
        if($req=$db->query($sql)){
            $res= $req->fetch(PDO::FETCH_ASSOC);
            return new BlogEntry($res['ID'], $res['USER_ID'], $res['ADDING_DATE'], $res['TITLE'], $res['CONTENT'], $res['CATEGORY_ID']);
        }
    }

    public function isLiked($userId){
        $db = DatabaseConnection::getInstance();
        $sql= "SELECT ID FROM liking WHERE USER_ID='$userId' AND BLOG_ENTRY_ID='$this->id'";
        $respond= $db->prepare($sql);
        $respond->execute();
        $count= $respond->rowCount();
        if($count>0) return true;
        return false;
    }

    public function countOfLikes(){
        $db = DatabaseConnection::getInstance();
        $sql= "SELECT COUNT(*) AS NUM FROM liking WHERE BLOG_ENTRY_ID='$this->id'";
        $respond= $db->prepare($sql);
        $respond->execute();
        $res= $respond->fetch(PDO::FETCH_ASSOC);
        return $res['NUM'];
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public static function getUserIdByPostId($id){
        $db = DatabaseConnection::getInstance();
        $sql= "SELECT USER_ID FROM blog_entry WHERE ID='".$id."'";
        if($req=$db->query($sql)){
            $res= $req->fetch(PDO::FETCH_ASSOC);
            return $res['USER_ID'];
        }
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        $db = DatabaseConnection::getInstance();
        $sql= "SELECT NAME FROM category WHERE ID='".$this->getCategoryId()."'";
        if($req=$db->query($sql)){
            $res= $req->fetch(PDO::FETCH_ASSOC);
            return $res['NAME'];
        }
    }



    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }



}