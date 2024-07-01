<?php
// include "connect.php";
include "models/project_model.php";
function get_project_data ($conn){
    # blank list of objects -> Array
    $prj_collection = array();
    
    $sql="select * from projects";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) { 

            $id = $row['pid'];
            $title = $row['ptitle'];
            $description = $row['pdesc'];
            $cost = $row['est_cost'];

            $prj_obj = new Project ($id, $description, $title, $cost);  //Create object & store data
            $prj_collection[] = $prj_obj;
        }
    }
    return $prj_collection;
}
?>