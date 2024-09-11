<?php
include("includes/demo_conn.php");

if(isset($_POST['title']) && $_POST['title']!=''){
	$title=mysqli_real_escape_string($_POST['title']);
	$slug=strtolower($title);
	$slug=str_replace(" ","-",$slug);
	$slug=str_replace("'","",$slug);

	$res=mysqli_query("select * from add_page where slug='$slug'");
	if(mysqli_num_rows($res)>0){
		$res=mysqli_query("select max(id) as id from post");
		$row=mysqli_fetch_assoc($res);
		$id=$row['id'];
		$id++;
		$slug=$slug.'-'.$id;
	}
	echo $slug;
}
?>