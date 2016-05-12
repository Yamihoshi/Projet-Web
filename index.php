
<?php 

include('nav.php');

?>
	<div id="pageDisplay">

		<div style="width:70%;margin:auto;">
			<img style="width:100%" src="saikyou.jpg">
		</div>

		<?php

		if(isConnected())
		{
			displayNews($bd);
		}

		?>
	</div>

</body>
</html>