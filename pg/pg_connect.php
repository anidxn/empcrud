<?php

   $host        = "host = 127.0.0.1";
   $port        = "port = 5432";
   $dbname      = "dbname = MISDBPR_01_03_2021";
   $credentials = "user = postgres password=postgres";

   $pg_conn = pg_connect( $host." ".$port." ".$dbname." ".$credentials );
   //$pg_conn = pg_connect( "host=localhost port=5432 dbname=MISDBPR_01_03_2021 user=postgres password=postgres");
   if(!$pg_conn) {
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }
?>