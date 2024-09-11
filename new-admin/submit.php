<?php
include("includes/demo_conn.php");

if(isset($_POST['title']) && $_POST['title']!='' && isset($_POST['slug']) && $_POST['slug']!=''){
	$title=mysqli_real_escape_string($_POST['title']);
	$slug=mysqli_real_escape_string($_POST['slug']);

	$res=mysqli_query("select * from add_page where slug='$slug'");
	if(mysqli_num_rows($res)>0){
		echo "Slug alreay added";
	}else{
		mysqli_query("Insert into add_page (title,slug) values('$title','$slug')");
		echo "Post added";
	}
}
?>