<?php 
require_once('config.php');
include('includes/heading.html'); 

$StudentID = $_REQUEST['StudentID'];
$pagenum = $_REQUEST['pagenum'];

//This checks to see if there is a page number. If not, it will set it to page 1
if (!(isset($pagenum)))
{
$pagenum = 1;
}

?>
<div align="center"><h1>Student Records</h1></div>
<table width="450" border="0" align="center" cellpadding="5" cellspacing="5">
<thead>
	<tr>
<!--		<th scope="col">Del</th> -->
		<th scope="col">Student ID</th>
		<th scope="col">Name</th>
		<th scope="col">Reg</th>
	</tr>
</thead>
<tbody>
<?php
mysql_select_db($database_equip, $equip);
$query_Students = "SELECT * FROM students ORDER BY students.LastName ASC";
$Students = mysql_query($query_Students, $equip) or die(mysql_error());
$row_Students = mysql_fetch_assoc($Students);
$totalRows_Students = mysql_num_rows($Students);

//This is the number of results displayed per page
$page_rows = 20;

//This tells us the page number of our last page
$last = ceil($totalRows_Students/$page_rows);

//this makes sure the page number isn't below one, or more than our maximum pages
if ($pagenum < 1) {
	$pagenum = 1;
} elseif ($pagenum > $last) {
	$pagenum = $last;
}

//This sets the range to display in our query
$max = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows; 

//This is your query again, the same one... the only difference is we add $max into it
$data_p = mysql_query("SELECT * FROM students ORDER BY students.LastName ASC $max") or die(mysql_error());

//This is where you display your query results
while($info = mysql_fetch_assoc($data_p)) {

?>

<tr>
  <!-- <td><a href="#" onClick="answer=confirm('Do you wish to remove <?php echo $info['FirstName']; ?> <?php echo $info['LastName']; ?> from the student records?');if(answer!=0){delEntry();}else{alert('Canceled')}"><img src="images/remove_icn.png" border="0" /></a></td> -->
	<td><a href="studentinfo.php?StudentID=<?php echo $info['StudentID']; ?>"><?php echo $info['StudentID']; ?></a></td>
	<td><?php echo $info['LastName']; ?>, <?php echo $info['FirstName']; ?></td>
	<td><?php if ($info['ContractSigned'] != "1"){
			echo "No";}
			else { echo "Yes";}	 ?></td>
</tr>

<?php } ?>

</tbody>
</table>
<?php 
echo "<center><p>";

// This shows the user what page they are on, and the total number of pages
echo " --Page $pagenum of $last-- </p>";

// First we check if we are on page one. If we are then we don't need a link to the previous page or the first page so we do nothing. If we aren't then we generate links to the first page, and to the previous page.
if ($pagenum == 1)
{
echo " <a class='pagenum' title='Beginning of Records'><< First</a> ";
echo " <a class='pagenum' title='Beginning of Records'>< Previous</a> ";
}
else
{
echo " <a class='pagenum' href='{$_SERVER['PHP_SELF']}?pagenum=1'> << First</a> ";
$previous = $pagenum-1;
echo " <a class='pagenum' href='{$_SERVER['PHP_SELF']}?pagenum=$previous'> < Previous</a> ";
}

//just a spacer
echo "&nbsp;&nbsp;&nbsp;";

//This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
if ($pagenum == $last)
{
echo " <a class='pagenum' title='End of Records'>Next ></a> ";
echo " <a class='pagenum' title='End of Records'>Last >></a> ";
}
else {
$next = $pagenum+1;
echo " <a class='pagenum' href='{$_SERVER['PHP_SELF']}?pagenum=$next'>Next ></a> ";
echo " ";
echo " <a class='pagenum' href='{$_SERVER['PHP_SELF']}?pagenum=$last'>Last >></a> ";
echo " </center> ";
}
?> 
<?php mysql_free_result($Students); ?>
<? include('includes/footer.html');  ?>
