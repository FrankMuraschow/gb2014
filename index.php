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
		<!-- <div id="bgOverlay"></div> -->
		<nav>
			<div class="navButton left transisitionAllFast" id="btnAttendance">
				Teilnahme
			</div>
			<div class="navButton left transisitionAllFast" id="btnProvision">
				Versorgung
			</div>
			<div class="navButton left transisitionAllFast" id="btnLocation">
				Anfahrt
			</div>
			<div class="navButton left transisitionAllFast" id="btnAccommodation">
				Unterbringung
			</div>
			<div class="navButton right transisitionAllFast" id="btnLogout">
				
			</div>
		</nav>
		<div id="outerWraper">
			<div id="innerWrapper" class="transisitionAllMed darkGradient">
				<div class="gradient accentLine"></div>
				<div class="content right" id="ctnLogin">

				</div>
				<div class="content right" id="ctnAttendance">

				</div>
				<div class="content right" id="ctnProvision">

				</div>
				<div class="content right" id="ctnLocation">

				</div>
				<div class="content right" id="ctnAccommodation">

				</div>
			</div>
		</div>
	</body>
</html>