<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/DatabaseConnection.php';
require_once 'Detail.php';

class Registration
{
    private $email;
    private $login;
    private $psw;
    private $psw_repeat;
    private $hashPassword;
    private $regulation;
    private $recaptcha;

    private $db;


    /**
     * Registration constructor.
     * @param $email
     * @param $login
     * @param $psw
     * @param $psw_repeat
     * @param $regulation
     * @param $recaptcha
     */
    public function __construct($email, $login, $psw, $psw_repeat, $regulation, $recaptcha)
    {
        $_SESSION['which_form']='registerView.php';

        $this->email = $email;
        $this->login = $login;
        $this->psw = $psw;
        $this->psw_repeat = $psw_repeat;
        $this->regulation = $regulation;
        $this->recaptcha= $recaptcha;

        $this->db=DatabaseConnection::getInstance();
    }


    public function register(){
        $this->setInputValues();

        if($this->isLoginCorrect()& $this->isPswCorrect() & $this->isEmailCorrect()& $this->isRegulationAccepted() &
            $this->checkReCaptcha() &
            $this->isUserNotAlreadyExist())
        {

            $this->hashPassword=$this->hashPassword();
            try
            {

                // $detail= new Detail();
                // $detail->addToDB();
                // $id_detail =$detail->getId();
                $sql= "INSERT INTO userr VALUES (NULL, :email, :login, :hashPsw,1)";
                $respond= $this->db->prepare($sql);

                $respond->bindParam(':email', $this->email);
                $respond->bindParam(':login', $this->login);
                $respond->bindParam(':hashPsw', $this->hashPassword);

                if($respond->execute()){
                    $_SESSION['login']=$this->login;
                    $_SESSION['registration_succeeded']=true;
                    $_SESSION['log_in']=true;
                    Detail::addToDB();

                    header('Location: index.php');
                }
                else {
                    header('Location: /view/formView.php');
                    //I must here display some error !!!!
                    $this->setError('e_login',"nie udal sie zapis do bazy" );

                }

            }catch (Exception $e){echo $e->getMessage();}

        }
        else
        {
            header('Location: /view/formView.php');
            //$this->setError('e_login',"cos podalo sie zle" );
        }
    }


    public function setError($sessionName, $message){
        $_SESSION[$sessionName] = $message;
    }

    public function isLoginCorrect(){

        if(strlen($this->login)<4 || strlen($this->login)>20 )
        {

            unset($_SESSION['e_login']);
            $this->setError('e_login',"Login musi posiadać od 4 do 20 znaków" );
            return false;
        }

        if(!ctype_alnum($this->login))
        {
            $this->setError('e_login', "Login może składać się tylko z liter i cyfr (bez polskich znaków)");
            return false;
        }

        return true;
    }

    public function isEmailCorrect(){
        $emailSave=filter_var($this->email, FILTER_SANITIZE_EMAIL);
        if(!filter_var($emailSave, FILTER_VALIDATE_EMAIL) || $emailSave!=$this->email)
        {

            $this->setError('e_email', 'Podaj poprawny adres email' );
            return false;
        }

        return true;
    }


    public function isPswCorrect(){
        if ((strlen($this->psw)<5) || (strlen($this->psw)>20))
        {

            $this->setError('e_psw',"Hasło musi posiadać od 5 do 20 znaków!" );
            return false;
        }

        if ($this->psw!=$this->psw_repeat)
        {

            $this->setError('e_psw', "Podane hasła nie są identyczne!");
            return false;
        }

        return true;
    }

    public function hashPassword(){

        return password_hash($this->psw, PASSWORD_DEFAULT);
    }

    public function isRegulationAccepted(){
        if(!$this->regulation)
        {
            $this->setError('e_reg','Potwierdź akcjeptację regulaminu!!!');
            return false;
        }
        return true;
    }


    public function checkReCaptcha(){
        $secret = "6LcR9zYUAAAAANhWQlmmcnkNqF_VcPbn29HH-xot";
        $check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$this->recaptcha);
        $answer = json_decode($check);

        if ($answer->success==false)
        {

            $this->setError('e_bot', "Potwierdź, że nie jesteś botem!");
            return false;
        }

        return true;
    }

    public function isUserNotAlreadyExist(){
        try{

            $result = $this->db->query("SELECT ID FROM userr WHERE EMAIL='$this->email'");
            //if(!$result) throw new Exception($this->db->errorInfo());

            $how_many_emails = $result->rowCount();
            if($how_many_emails>0)
            {

                $this->setError('e_email', "Istnieje już konto przypisane do tego adresu e-mail!");
                return false;
            }


            $result = $this->db->query("SELECT ID FROM userr WHERE LOGIN='$this->login'");

            $how_many_logins = $result->rowCount();
            if($how_many_logins>0)
            {

                $this->setError('e_login',"Istnieje już użytkownik o takim loginie! Wybierz inny." );
                return false;
            }

            return true;
        }catch (Exception $e){ return false;}

    }

    public function setInputValues(){

        $_SESSION['form_login'] = $this->login;
        $_SESSION['form_email'] = $this->email;
        if (isset($_POST['regulation'])) $_SESSION['form_regulation'] = true;

    }



}