<?php
include_once("header.php");
print_header(get_tr("SMPlayer - Formats and Codecs"));
echo "<body>\n";
print_menu();
?>

<div class="container">

<?php
echo "<h1>" . get_tr("Formats and Codecs") ."</h1>";
include("formats_text.php"); 
?>

</div> <!-- container -->

<!-- begin footer -->
<?php
include("footer.php");
?>
<!-- end footer -->

</body>
</html>
