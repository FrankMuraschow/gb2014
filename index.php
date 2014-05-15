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
		<nav class="unselectable" onselectstart="return false;" onmousedown="return false;" unselectable"on">
			<div class="navButton left transisitionAllFast hidden unselectable" id="btnAttendance" onselectstart="return false;" onmousedown="return false;" unselectable"on">
				Teilnahme
			</div>
			<div class="navButton left transisitionAllFast hidden unselectable" id="btnProvision" onselectstart="return false;" onmousedown="return false;" unselectable"on">
				Versorgung
			</div>
			<div class="navButton left transisitionAllFast hidden unselectable" id="btnLocation" onselectstart="return false;" onmousedown="return false;" unselectable"on">
				Anfahrt
			</div>
			<div class="navButton left transisitionAllFast hidden unselectable" id="btnAccommodation" onselectstart="return false;" onmousedown="return false;" unselectable"on">
				Unterbringung
			</div>
			<div class="navButton right transisitionAllFast active unselectable" id="btnLogin" onselectstart="return false;" onmousedown="return false;" unselectable"on">
				Login
			</div>
		</nav>
		<div id="outerWrapper">
			<div id="innerWrapper" class="transisitionAllMed darkGradient">
				<div class="gradient accentLine"></div>
				
				<div class="content left" id="ctnLogin">
					<div class="introText">
						Hier teilst du uns mit, ob du zur Feier kommen wirst.
						<br />
						Solltest du dabei sein, hast du die Möglichkeit, jemanden mitzubringen. Diese Person wird daraufhin eine E-Mail mit den entsprechenden Zugangsdaten erhalten.
					</div>
					<div class="middle bigButtonContainer table">
						<input type="text" class="bdTextfield big left table-cell inital transisitionAllFast" value="Passwort" id="tbPassword" />
						<div class="bdButton big table-cell transisitionAllFast" id="btnPassword">
							OK
						</div>
					</div>
				</div>

				<div class="content left" id="ctnAttendance">
					<div class="introText">
						Hier teilst du uns mit, ob du zur Feier kommen wirst.
						<br />
						Solltest du dabei sein, hast du die Möglichkeit, jemanden mitzubringen. Diese Person wird daraufhin eine E-Mail mit den entsprechenden Zugangsdaten erhalten.
					</div>
					<div class="content_bg_wrapper">
						<div class="content_bg"></div>
					</div>
				</div>
				<div class="content left" id="ctnProvision">
					<div class="introText">
						Hier teilst du uns mit, ob du zur Feier kommen wirst.
						<br />
						Solltest du dabei sein, hast du die Möglichkeit, jemanden mitzubringen. Diese Person wird daraufhin eine E-Mail mit den entsprechenden Zugangsdaten erhalten.
					</div>
					<div class="content_bg_wrapper">
						<div class="content_bg"></div>
					</div>
				</div>
				<div class="content left" id="ctnLocation">
					<div class="introText">
						Hier teilst du uns mit, ob du zur Feier kommen wirst.
						<br />
						Solltest du dabei sein, hast du die Möglichkeit, jemanden mitzubringen. Diese Person wird daraufhin eine E-Mail mit den entsprechenden Zugangsdaten erhalten.
					</div>
					<div class="content_bg_wrapper">
						<div class="content_bg"></div>
					</div>
				</div>
				<div class="content left" id="ctnAccommodation">
					<div class="introText">
						Hier teilst du uns mit, ob du zur Feier kommen wirst.
						<br />
						Solltest du dabei sein, hast du die Möglichkeit, jemanden mitzubringen. Diese Person wird daraufhin eine E-Mail mit den entsprechenden Zugangsdaten erhalten.
					</div>
					<div class="content_bg_wrapper">
						<div class="content_bg"></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>