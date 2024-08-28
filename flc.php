<?php
class fnc{
    var $fname;
    var $yob;
    public $username;
    protected $email_address;
    private $password;

    public function computer_user($fname){
          return $fname . " is currently using this computer. ";
    }

    public function user_age ($name, $yob){
       $age = date('Y') - $yob;
       return $name . " is " .$age;

    }
}

/*$Obj = new fnc();
print $Obj->user_age("Patrick", 1964);
echo "<br>";
print $Obj-> computer_user("Maina");*?