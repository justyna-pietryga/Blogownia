<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/DatabaseConnection.php';

class Login
{
    private $email;
    private $login;
    private $hashPassword;

    private $db;
    private $req;
    private $row;

    /**
     * Login constructor.
     * @param $email
     * @param $login
     * @param $hashPassword
     * @internal param $password
     */

    public function __construct($email, $login, $hashPassword)
    {
        $_SESSION['which_form']='loginView.php';
        $this->email = $email;
        $this->login = $login;
        $this->hashPassword = $hashPassword;
        $this->db=DatabaseConnection::getInstance();
    }


    public function isUserExist(){
        $sql= "SELECT * FROM userr WHERE EMAIL = :email OR LOGIN= :login";
        $req=$this->db->prepare($sql);
        $req->execute(array(':email' => $this->email, ':login' => $this->login));
        $this->setReq($req);
        $amount_of_users=$this->req->rowCount();

        if ($amount_of_users>0){
            return true;
        }
        else {
            return false;
        }
    }

    public function verifyPassword(){
        $row=$this->getReq()->fetch(PDO::FETCH_ASSOC);
        $this->setRow($row);
        if(password_verify($this->hashPassword, $row['PASSWORD'])){
            return true;
        }
        else{
            return false;
        }
    }

    public function setError($sessionName, $message){
        $_SESSION[$sessionName] = '<span style="color:red">'.$message.'</span>';
    }


    public function login(){
        if($this->isUserExist()){
            if($this->verifyPassword()){
                $_SESSION['log_in']=true;
                $_SESSION['login']=$this->getRow()['LOGIN'];

                $this->getReq()->closeCursor();
                unset($_SESSION['login_error']);

                $sql= "SELECT ID FROM userr WHERE EMAIL = :email OR LOGIN= :login";
                $req=$this->db->prepare($sql);
                $req->execute(array(':email' => $this->email, ':login' => $this->login));
                $this->setReq($req);
                $res= $this->getReq()->fetch();
                $_SESSION['login_id']=$res['ID'];
                header('Location: index.php');


            }else{
                $this->setError('login_error', 'Nieprawidłowy login lub hasło!');
                header('Location: /view/formView.php');
            }
        }else{
            $this->setError('login_error', 'Nieprawidłowy login lub hasło!');
            header('Location: /view/formView.php');
        }


    }

    /**
     * @return null|PDO
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param null|PDO $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @return mixed
     */
    public function getReq()
    {
        return $this->req;
    }

    /**
     * @param mixed $req
     */
    public function setReq($req)
    {
        $this->req = $req;
    }

    /**
     * @return mixed
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * @param mixed $row
     */
    public function setRow($row)
    {
        $this->row = $row;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getHashPassword()
    {
        return $this->hashPassword;
    }

    /**
     * @param mixed $hashPassword
     */
    public function setHashPassword($hashPassword)
    {
        $this->hashPassword = $hashPassword;
    }




}