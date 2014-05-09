<?php
require_once ('FirePHP.class.php');
ob_start();
?>
<!DOCTYPE html>
<html>
	<?php
	include_once 'inc/inc_header.php';
	?>
	<body>
		<nav>
			<div class="navButton left" id="btnAttendance">
				Teilnahme
			</div>
			<div class="navButton left" id="btnProvision">
				Versorgung
			</div>
			<div class="navButton left" id="btnLocation">
				Anfahrt
			</div>
			<div class="navButton left" id="btnAccommodation">
				Unterbringung
			</div>
			<div class="navButton right" id="btnLogout">
				
			</div>
		</nav>
		<div id="outerWraper">
			<div id="innerWrapper" class="gradient">
				<div class="content login right">

				</div>
				<div class="content attendance right">

				</div>
				<div class="content provision right">

				</div>
				<div class="content location right">

				</div>
				<div class="content accommodation right">

				</div>
			</div>
		</div>
	</body>
</html>