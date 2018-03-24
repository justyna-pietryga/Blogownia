<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/DatabaseConnection.php';

class Account
{
    private $id;
    private $login;
    private $name;
    private $surname;
    private $description;
    private $followers;

    private $db;


    public function __construct($login)
    {
        $this->login = $login;
        $this->db=DatabaseConnection::getInstance();
        $req = $this->db->query("SELECT * FROM users WHERE LOGIN='$login'");

        if($req){
            $amount_of_users=$req->rowCount();

            if ($amount_of_users>0) {
                $row = $req->fetch(PDO::FETCH_ASSOC);
                $this->id=$row['ID'];
                $this->name=$row['NAME'];
                $this->surname=$row['SURNAME'];
                $this->description=$row['DESCRIPTION'];

                if($this->name==''& $this->surname==''){
                    $this->name="Mr.";
                    $this->surname="Noname";
                }

            }
        }
    }

    /**
     * @param $login
     */
    public static function getId($login)
    {
        $db = DatabaseConnection::getInstance();
        $sql= "SELECT ID FROM userr WHERE LOGIN='".$login."'";
        if($req=$db->query($sql)){
            $res= $req->fetch(PDO::FETCH_ASSOC);
            return $res['ID'];
        }

        echo 'Blad w otrzymaniu id uzytkownika';
        return 0;
    }



    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    public function getUserId()
    {
        return $this->id;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }



    public static function changeLoginDB($login, $id){
        $db= DatabaseConnection::getInstance();
        if(Account::isLoginCorrect($login) & Account::isUserNotAlreadyExist($login)){
            $sql= "UPDATE userr SET LOGIN=:login WHERE ID='$id'";
            $respond= $db->prepare($sql);

            $respond->bindParam(':login', $login);
            if($respond->execute()){
                $_SESSION['login']=$login;
            }
            else{
                echo 'cos nie pycło';
            }
        }
        else{
            echo "nie pycło";
        }
    }

    public static function getLoginByID($id){
        $db = DatabaseConnection::getInstance();
        $sql= "SELECT LOGIN FROM userr WHERE ID='".$id."'";
        if($req=$db->query($sql)){
            $res= $req->fetch(PDO::FETCH_ASSOC);
            return $res['LOGIN'];
        }
    }

    //////////
    public static function isLoginCorrect($login){

        if(strlen($login)<4 || strlen($login)>20 )
        {

            unset($_SESSION['e_login']);
            //setError('e_login',"Login musi posiadać od 4 do 20 znaków" );
            return false;
        }

        if(!ctype_alnum($login))
        {
            //('e_login', "Login może składać się tylko z liter i cyfr (bez polskich znaków)");
            return false;
        }

        return true;
    }


    public static function isUserNotAlreadyExist($login){
        try{
            $db= DatabaseConnection::getInstance();
            $result = $db->query("SELECT ID FROM userr WHERE LOGIN='$login'");

            $how_many_logins = $result->rowCount();
            if($how_many_logins>0)
            {

                //setError('e_login',"Istnieje już użytkownik o takim loginie! Wybierz inny." );
                return false;
            }

            return true;
        }catch (Exception $e){ return false;}

    }

    public static function getFromDB($id, $column){
        $db= DatabaseConnection::getInstance();
        $sql="SELECT ".$column." FROM userr WHERE ID='".$id."'";
        $respond= $db->query($sql);
        $result= $respond->fetch();
        return $result[$column];

    }

    public static function getFollowers($id){
        $db= DatabaseConnection::getInstance();
        //$sql="SELECT COUNT(ID) FROM subscription WHERE USER_TO='$id'";
        $sql="SELECT ID FROM subscription WHERE USER_TO='$id'";
        $respond= $db->prepare($sql);
        $respond->execute();
        echo $respond->rowCount();
    }

    public static function getFollowings($id){
        $db= DatabaseConnection::getInstance();
        //$sql="SELECT COUNT(ID) FROM subscription WHERE USER_TO='$id'";
        $sql="SELECT ID FROM subscription WHERE USER_FROM='$id'";
        $respond= $db->prepare($sql);
        $respond->execute();
        echo $respond->rowCount();
    }

    public static function isSubscribe($idFrom, $idTo){
        $db= DatabaseConnection::getInstance();
        $sql="SELECT ID FROM subscription WHERE USER_FROM='$idFrom' AND USER_TO='$idTo'";
        $respond= $db->prepare($sql);
        $respond->execute();
        $count= $respond->rowCount();
        if($count>0) return true;
        return false;
    }

    public static function getTheMostLiked(){
        $list=[];
        $db = DatabaseConnection::getInstance();
        $req= $db->query("SELECT U.LOGIN AS login, COUNT(*) FROM subscription AS S INNER JOIN userr AS U ON S.USER_TO=U.ID GROUP BY S.USER_TO ORDER BY COUNT(*) DESC LIMIT 10");

        foreach($req->fetchAll(PDO::FETCH_ASSOC) as $user) {
            $list[] = $user['login'] ;
        }

        return $list;
    }

    public static function getAll(){
        $list=[];
        $db = DatabaseConnection::getInstance();
        $req= $db->query("SELECT * FROM userr");

        foreach($req->fetchAll(PDO::FETCH_ASSOC) as $user) {
            $list[] = new Account($user['LOGIN']) ;
        }

        return $list;
    }

    public static function isAdmin($id)
    {
        $db= DatabaseConnection::getInstance();
        $sql="SELECT R.ROLE AS role FROM roles AS R INNER JOIN userr AS U ON U.ID_ROLE=R.ID WHERE U.ID='".$id."'";
        $respond= $db->query($sql);
        $result= $respond->fetch();
        if($result['role']=='admin') return true;
        else return false;
    }


}