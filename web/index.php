<?php
include_once("site.php");
include_once("header.php");
include_once("download_links.php");
print_header("");
echo "<body>\n";
print_menu(1);
?>

<div class="container-fluid">

<?php
if (0)
	include("info.php");
else
	include("info2.php");
?>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
