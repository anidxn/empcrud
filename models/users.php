<?php

class Users {
    //datamember
    private $uid;
    private $acc_level;
    private $uname;
    private $ename;
    private $upass;
    private $email;

    public function __construct ($a, $b, $c, $d, $e , $f){
        $this -> uid = $a;
        $this -> acc_level = $b;
        $this -> uname = $c;
        $this -> ename = $d;
        $this -> upass = $e;
        $this -> email = $f;

    }

    public function get_uid (){
        return $this->uid;
    }
    public function get_alevel (){
        return $this->acc_level;
    }
    public function get_uname (){
        return $this->uname;
    }
    public function get_ename (){
        return $this->ename;
    }
    public function get_upass (){
        return $this->upass;
    }
    public function get_email (){
        return $this->email;
    }
}

?>