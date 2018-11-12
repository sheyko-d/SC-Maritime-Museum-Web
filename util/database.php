<?php

class DBConnect
{

    public function __construct()
    {
        $this->host = "zioncg1.clbrnd07xbtf.us-east-1.rds.amazonaws.com";
        $this->username = "scmm_webapp";
        $this->password = "W^\"iu^M\"[wpB]]5vB3aWndoT)4{W%i[gL]4}#y~+";
        $this->database = "scmm_webapp";
    }

    public function openConnection()
    {
        $con = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (!$con) {
            die("Could not connect: " . mysqli_error($con));
        }

        return $con;
    }

    public function makeQuery($con, $query)
    {
        $query = mysqli_query($con, $query) or die('Error in query execution: ' . mysqli_error($con));
        return $query;
    }

    public function countResults($query)
    {
        return mysqli_num_rows($query);
    }

    public function closeConnection($con)
    {
        mysqli_close($con);
    }

}
