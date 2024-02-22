
<!DOCTYPE html>
<html>
    <head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="res/css/navstyle.css">
	
    <script src="res/js/jquery.min.js"></script>
    <!-- autocomplete -->
    
    <link rel="stylesheet" type="text/css" href="res/css/jquery_ui/1.13.2/jquery-ui.css"/>
    <script src="res/js/jquery_ui/1.13.2/jquery-ui.min.js"></script> 

    <script>
        /*
        $(function() {    
            $("#txtptitle").autocomplete({     
                 source :  "serverajax.php?ajaxcode=2"
            });
        });
        */
    </script>
    </head>
	<body>
    <?php include 'navbar.php'; ?>

      This page uses jquery to populate autocomplete search & saves data using prepared statement in Mysql db <p>
        <form action="serverops.php?opcode=5" method="post">
			<table width="50%">
				<tr>
					<td>Project title name:</td><td><input type="text" name="txtptitle" id="txtptitle" placeholder="search project by title"/></td>
				</tr>
				<tr>
					<td>Description:</td><td><textarea name="txtpdesc" id="txtpdesc" rows="4" cols="50"></textarea></td>
				</tr>
                <tr>
					<td>Estimated cost:</td><td><input type="text" name="txtcost" id="txtcost"/></td>
				</tr>
				
				<tr>
					<td colspan="2"><input type="submit" name="submit" id="submit" value="Save project"/></td>
				</tr>
				
			</table>
        </form>

<?php

if(isset($_GET['status'])) {
	if ( $_GET['status'] == 1) {
		echo "<script>alert('Data saved successfully');</script>";
	} else {
		echo "<script>alert('Failed to save data');</script>";
	}
}

?>

	</body>

    <!-- <script src="res/js/jquery_ui/1.12.1/jquery-ui.js"></script> -->
    
    <script>
        
        $(document).ready(function() {
            $(function() {
                //-------- works - just shows the suggestion list --------
                /*
                $('#txtptitle').autocomplete({
                    source: function (request, response) {
                        $.getJSON('serverajax.php', { term: request.term, ajaxcode : 2 }, 
                            function (data) {
                                response(data);
                            });
                    }
                    //, minLength: 2
                });

                */

                //--------- This works too : suggest & upon selecttion show details --------

                $("#txtptitle").autocomplete({     
                    source :  "serverajax.php?ajaxcode=2",
                    // minLength : 3,
                    select: function( event, ui ) {
                        //event.preventDefault(); -- prevent default action i.e. setting the selected value in the textbox
                        var selval = ui.item.value;
                        //console.log(selval);
                        
                        $.getJSON('serverajax.php', 
                            {   ptitle : selval,
                                ajaxcode : 3 },
                            
                            function(result) {
                                result.forEach(function(data) {  //this looping is required for [{},{}, {}...] format data
                                    $('#txtpdesc').val(data.pdesc);
                                    $('#txtcost').val(data.est_cost);
                                });
                            });
                    
                        //return false;
                    }
                });

                //-------- WORKING CODE (suggest & upon selecttion show details)----------
                /*
                $("#txtptitle").autocomplete({     
                    source : function(request, response) {
                    $.ajax({
                        url :  "serverajax.php",
                        type : "GET",
                        data : {
                            term : request.term,
                            ajaxcode : 2,
                        },
                        dataType : "json",
                        success : function(data) {
                            response(data);
                        }
                    });
                }  ,
                //minLength : 4
                select: function( event, ui ) {
                    //event.preventDefault(); -- prevent default action i.e. setting the selected value in the textbox
                    var selval = ui.item.value;
                        
                        $.getJSON('serverajax.php', 
                            {   ptitle : selval,
                                ajaxcode : 3 },
                            
                            function(result) {
                                result.forEach(function(data) {  //this looping is required for [{},{}, {}...] format data
                                    $('#txtpdesc').val(data.pdesc);
                                    $('#txtcost').val(data.est_cost);
                                });
                            });
                    
                        //return false;
                }
                });
                */
                
            });
        });
    
    </script>
</html>