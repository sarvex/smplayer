<?php
include_once("site.php");
include_once("header.php");
include_once("download_links.php");
print_header();
echo "<body>\n";
print_menu(1);
?>

<div class="container-fluid">

<?php
if ($site != "berlios")
	include("info2.php");
else
	include("info.php");
?>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>