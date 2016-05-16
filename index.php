
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
			echo '<div id="news">';
			displayNews($bd,0);
			echo '</div>';

			echo '<div id="loadMoreTouiteDiv">
				<button id="loadMoreNewsTouite" next="1">+ de Touites</button>

			</div>';
		}

		?>
	</div>

</body>
</html>