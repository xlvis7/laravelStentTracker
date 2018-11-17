<?php 

include 'core/init.php';
protect_page();
include 'includes/overall/header.php';



?>
<h1> HISTORY OF THE ANSWER OF THE USER</h1>
<?php function display(){

$connect_error ='sorry we are experiencing connection issue.Please check your internet service provider';
$dbconn = mysql_connect("localhost", "root", "")or die($connect_error);
			mysql_select_db("lr")or die($connect_error);
			
$sql = mysql_query("SELECT * FROM expert");
$counter = 0;
try
			{
				if(!empty($sql))
				{	
					while($row = mysql_fetch_assoc($sql))
					{			
						$row_Val = $row["symptoms"];
						$row_Val2 = $row["marks"];
						
						if(isset ($_SESSION['counter2']))
						{
							if(isset($_SESSION['answer']) && $_SESSION['counter2'] > $counter)
							{
								echo "Does the ".$row_Val.";  answer :". $_SESSION['answer_Literal'][$counter] . "<br/><br/>";
								//echo "Does the ".$row_Val." answer :". $_SESSION['answer'][$counter] . "<br/>";
							}
						}
						
						$counter++;
					}
				}
					else {
					}
				}
				catch( PDOException $e)
			{
				echo "Query failed:".$e->getMessage();
			}
				
}
?>

<?php
 display();
include 'includes/overall/footer.php'
?>