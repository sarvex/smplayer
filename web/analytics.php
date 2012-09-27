<?php 
include_once("site.php"); 
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  <?php
  global $site;
  if ($site == "berlios")
    echo "_gaq.push(['_setAccount', 'UA-34675390-2']);\n";
  else
    echo "_gaq.push(['_setAccount', 'UA-34675390-1']);\n";
  ?>
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
