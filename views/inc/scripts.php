<script src="<?php echo SERVERURL; ?>views/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo SERVERURL; ?>views/js/bootstrap.min.js"></script>
<script src="<?php echo SERVERURL; ?>views/js/material.min.js"></script>
<script src="<?php echo SERVERURL; ?>views/js/ripples.min.js"></script>
<script src="<?php echo SERVERURL; ?>views/js/trumbowyg.min.js"></script>
<script src="<?php echo SERVERURL; ?>views/js/es.min.js"></script>
<script>
	$('#spv-editor').trumbowyg({
	    btns: [
	        ['viewHTML'],
	        ['undo', 'redo'], // Only supported in Blink browsers
	        ['formatting'],
	        ['strong', 'em', 'del'],
	        ['superscript', 'subscript'],
	        ['link'],
	        ['insertImage'],
	        ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
	        ['unorderedList', 'orderedList'],
	        ['horizontalRule'],
	        ['removeformat'],
	        ['fullscreen']
	    ],
	    autogrow: true,
	    lang: 'es'
	});
</script>
<script src="<?php echo SERVERURL; ?>views/js/main.js"></script>
<script>
	$.material.init();
</script>