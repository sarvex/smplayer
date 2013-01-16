<?php
include_once("header.php");
print_header("TEST", "TEST");
echo "<body>\n";
print_menu(0);
?>

<div class="container-fluid">
<h1>TEST</h1>

<div class="span4">
<div class="well">

<?php
include("reviews_box.php");
?>

</div> <!-- well -->
</div> <!-- span -->

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
enable_carousel(3000);
?>
<!-- end footer -->

</body>
</html>
