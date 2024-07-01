<?php

class Project {
    //datamember
    private $pid;
    private $pdesc;
    private $ptitle;
    private $est_cost;

    public function __construct ($a, $b, $c, $d){
        $this -> pid = $a;
        $this -> pdesc = $b;
        $this -> ptitle = $c;
        $this -> est_cost = $d;


    }

    public function get_pid (){
        return $this->pid;
    }
    public function get_desc (){
        return $this->pdesc;
    }
    public function get_ptit (){
        return $this->ptitle;
    }
    public function get_est_cost (){
        return $this->est_cost;
    }

}

?>