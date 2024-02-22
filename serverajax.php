<?php
require_once 'connect.php';

$ajaxcode= $_GET['ajaxcode'];
if ( $ajaxcode == 1) {  //search district
	if(isset($_POST['ddlscode'])) {
		$ddl_scode = trim($_POST['ddlscode']);
		
		$sql="select * from mas_district where scode=".$ddl_scode;
		
		$result=$conn->query($sql);
        $ddlDistData = '';
		if ($result->num_rows > 0) {  // should be 1
            $ddlDistData = "<select id='ddldist' name='ddldist'><option value='0'>-- select --</option>";
			while ($row = $result->fetch_assoc()) { 

                $ddlDistData = $ddlDistData."<option value='".$row['scode']."~".$row['dcode']."' >".$row['dname']."</option>";
				
			}
            $ddlDistData = $ddlDistData.'</select>';
			
			$result->free_result(); //FREE the resultset
        }
		$conn->close();

		echo $ddlDistData;  //return data 
	}
} else if ( $ajaxcode == 2) {  //search project
	if(isset($_GET['term'])) {
		$key = trim($_GET['term']);

		// * * * * * * DON'T USE ECHO FOR DEBUGGING AJAX CALLS * * * * * * *

		$sql = "select * from projects where ptitle like '%$key%'";

		$result=$conn->query($sql);
        $parray = array();

		if ($result->num_rows > 0) {  // should be 1
            
			while ($row = $result->fetch_assoc()) { 
				$parray[] = $row['ptitle'];
				//or  array_push($parray, $row['ptitle']);
				
				/* Embed entire row in the resultset
					$parray[] = $row;   
					output: [{"pid":"1","ptitle":"walmart","pdesc":"Inventory management software","est_cost":"500000"},{"pid":"2","ptitle":"Home depot","pdesc":"Inventory management software","est_cost":"450000"},....]
				*/

				/*
				Embed selected column data with custom colmn name

				$data['pid'] = $row['pid'];
				$data['ptitle'] = $row['ptitle'];
				array_push($parray, $data);
				
				output: [{"pid":"1","ptitle":"walmart"},{"pid":"2","ptitle":"Home depot"},{"pid":"3","ptitle":"Nike"}] 
				*/
			}
			$result->free_result(); //FREE the resultset
        }

		$conn->close();

		// --- write to json file ---
		/*
		$fp = fopen('data.json', 'w');
		fwrite($fp, json_encode($parray));
		fclose($fp);
		*/

		echo json_encode($parray);  //return data 
	}
}  else if ( $ajaxcode == 3) {  //search project
	if(isset($_GET['ptitle'])) {
		$key = trim($_GET['ptitle']);

		$sql = "select * from projects where ptitle='$key'";

		$result=$conn->query($sql);
        $parray = array();

		if ($result->num_rows > 0) {  // should be 1
			while ($row = $result->fetch_assoc()) { 
				
				// Embed entire row in the resultset
					$parray[] = $row;   
				/*
					output: [{"pid":"1","ptitle":"walmart","pdesc":"Inventory management software","est_cost":"500000"},{"pid":"2","ptitle":"Home depot","pdesc":"Inventory management software","est_cost":"450000"},....]
				*/
			}
			$result->free_result(); //FREE the resultset
        }

		$conn->close();

		// --- write to json file ---
		
		$fp = fopen('data-2.json', 'w');
		fwrite($fp, json_encode($parray));
		fclose($fp);
		

		echo json_encode($parray);  //return data 
	}
}

?>