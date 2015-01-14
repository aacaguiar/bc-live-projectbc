<script type="text/javascript">
var new_url = "<?php echo $url; ?>";
$(document).ready(function () { 
	myPDF = new PDFObject({ url: new_url }).embed("box-pdf");
});
</script>


