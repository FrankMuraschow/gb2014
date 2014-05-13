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
			<div class="navButton left transisitionAllFast hidden" id="btnAttendance">
				Teilnahme
			</div>
			<div class="navButton left transisitionAllFast hidden" id="btnProvision">
				Versorgung
			</div>
			<div class="navButton left transisitionAllFast hidden" id="btnLocation">
				Anfahrt
			</div>
			<div class="navButton left transisitionAllFast hidden" id="btnAccommodation">
				Unterbringung
			</div>
			<div class="navButton right transisitionAllFast active" id="btnLogin">
				Login
			</div>
		</nav>
		<div id="outerWrapper">
			<div id="innerWrapper" class="transisitionAllMed darkGradient">
				<div class="gradient accentLine"></div>
				<div class="content left" id="ctnLogin">
					<div class="middle bigButtonContainer table">
						<input type="text" class="bdTextfield big left table-cell inital transisitionAllFast" value="Passwort" id="tbPassword" />
						<div class="bdButton big table-cell transisitionAllFast" id="btnPassword">OK</div>
					</div>
				</div>

				<div class="content left" id="ctnAttendance">

				</div>
				<div class="content left" id="ctnProvision">

				</div>
				<div class="content left" id="ctnLocation">

				</div>
				<div class="content left" id="ctnAccommodation">

				</div>
			</div>
		</div>
	</body>
</html>