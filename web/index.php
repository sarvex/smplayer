<?php
include_once("site.php");
include_once("header.php");
include_once("download_links.php");
print_header("");
echo "<body>\n";
print_menu(1);

$print_user_reviews = true;
?>

<div class="container-fluid">

<?php
if (1)
	include("info.php");
else
	include("info2.php");
?>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");

if ($print_user_reviews) enable_carousel(15000);
?>
<!-- end footer -->

</body>
</html>
