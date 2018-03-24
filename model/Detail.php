<?php
require_once 'Account.php';
class Detail
{
    private $id=0;
    private $name="";
    private $surname="";
    private $description="";
    private $date_of_registration;
    private $visits_counter=0;
    private $id_contact=0;


    /**
     * Detail constructor.
     * @param $id
     */
    public function __construct()
    {
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

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
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

    /**
     * @return mixed
     */
    public function getDateOfRegistration()
    {
        return $this->date_of_registration;
    }

    /**
     * @param mixed $date_of_registration
     */
    public function setDateOfRegistration($date_of_registration)
    {
        $this->date_of_registration = $date_of_registration;
    }

    /**
     * @return mixed
     */
    public function getVisitsCounter()
    {
        return $this->visits_counter;
    }

    /**
     * @param mixed $visits_counter
     */
    public function setVisitsCounter($visits_counter)
    {
        $this->visits_counter = $visits_counter;
    }

    /**
     * @return mixed
     */
    public function getIdContact()
    {
        return $this->id_contact;
    }

    /**
     * @param mixed $id_contact
     */
    public function setIdContact($id_contact)
    {
        $this->id_contact = $id_contact;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    public static function addToDB(){

        $name=$surname=$description="";
        $db= DatabaseConnection::getInstance();
        //$sqlID= "SELECT ID FROM userr WHERE LOGIN=".$_SESSION['login'];
        $sqlID= Account::getId($_SESSION['login']);
        //$request=$db->query($sqlID);
        //$respond=$request->fetch();

        $sql= "INSERT INTO details VALUES (NULL, '$sqlID', :name, :surname, :description, CURRENT_TIMESTAMP , 1, 1 )"; //1, 1 testowe contact i social media
        $respond= $db->prepare($sql);

        $respond->bindParam(':name', $name);
        $respond->bindParam(':surname', $surname);
        $respond->bindParam(':description', $description);

        $respond->execute();

        // $amount=$db->lastInsertId();
        // $this->setId($amount);

    }

    public function changeName($name){
        $db= DatabaseConnection::getInstance();
        $sql= "UPDATE details SET NAME=:name WHERE ID='$this->id'";
        $respond= $db->prepare($sql);

        $respond->bindParam(':name', $name);
        if($respond->execute()){
        }
        else{
            echo 'cos nie pycło';
        }
    }

    public function changeSurname($surname){
        $db= DatabaseConnection::getInstance();
        $sql= "UPDATE details SET SURNAME=:surname WHERE ID='$this->id'";
        $respond= $db->prepare($sql);

        $respond->bindParam(':surname', $surname);
        if($respond->execute()){
        }
        else{
            echo 'cos nie pycło';
        }
    }

    public function changeDescription($description){
        $db= DatabaseConnection::getInstance();
        $sql= "UPDATE details SET DESCRIPTION=:description WHERE ID='$this->id'";
        $respond= $db->prepare($sql);

        $respond->bindParam(':description', $description);
        if($respond->execute()){
        }
        else{
            echo 'cos nie pycło';
        }
    }

    public static function getFromDB($id, $column){
        $db= DatabaseConnection::getInstance();
        $sql="SELECT ".$column." FROM details WHERE ID='".$id."'";
        $respond= $db->query($sql);
        $result= $respond->fetch();
        return $result[$column];

    }

}