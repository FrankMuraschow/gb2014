<?php
require_once ('FirePHP.class.php');
require_once ('conf.php');
require_once ('dbConnectController.php');
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>
	<?php
	$attendance = getAttendanceValue();
	include_once 'inc/inc_header.php';
	?>
	<body>
		<!-- <div id="bgOverlay"></div> -->
		<nav class="unselectable" onselectstart="return false;" onmousedown="return false;" unselectable="on">
			<?php
			if (isset($_SESSION['usr']) && !empty($_SESSION['usr'])) {
				echo conf::NAV_VIS;
				echo "<div class=\"navButton right transisitionAllFast unselectable\" id=\"btnLogout\" onselectstart=\"return false;\" onmousedown=\"return false;\" unselectable=\"on\">Logout</div>";
			} else {
				echo "<div class=\"navButton right transisitionAllFast active unselectable\" id=\"btnLogin\" onselectstart=\"return false;\" onmousedown=\"return false;\" unselectable=\"on\">Login</div>";
			}
			?>
		</nav>
		<div id="outerWrapper">

			<?php
if (isset($_SESSION['usr']) && !empty($_SESSION['usr'])) {
			?>
			<script type="application/javascript">
                renderInnerWrapper();
                function renderInnerWrapper() {
                    var windowWidth1015 = $(window).width() <= 1015, marVal = windowWidth1015 ? -1190 : -1390;
                    document.write('<div id="innerWrapper" class="transisitionAllMed darkGradient" style="margin-left:' + marVal + 'px">');
                }
			</script>
			<?php } else { ?>
			<div id="innerWrapper" class="transisitionAllMed darkGradient">
				<?php } ?>

				<div class="gradient accentLine"></div>

				<!-- Login -->
				<div class="content left table" id="ctnLogin">
					<div class="introText">
						<div class="header">
							Anmeldung
						</div>
						<div class="content">
							Bitte melde dich hier mit den Nutzerdaten an.
							<br />
							Hast du noch keine erhalten? Dann melde dich <a href="mailto:frankmur1983@hotmail.com?subject=Keine%20Zugangsdaten%20fuer%20die%20Geburtstagsseite">hier</a>.
						</div>
					</div>
					<div class="table-row">
						<div class="table-cell vMiddle textCenter">
							<div class="table inlineBlock bigButtonContainer">
								<div class="table-row">
									<div class="table-cell left">
										<input type="text" class="bdTextfield big inital transisitionAllFast" value="Nutzername" id="tbUser" />
									</div>
								</div>
								<div class="table-row smallTopMargin">
									<div class="table-cell">
										<input type="password" class="bdTextfield big inital transisitionAllFast" value="Passwort" id="tbPassword" />
									</div>
									<div class="table-cell vMiddle">
										<div class="table">
											<div class="bdButton big table-cell transisitionAllSuperFast vMiddle" id="btnPassword">
												<img src="assets/img/ajax_loader_bars.gif" alt="Loading" id="pwLoader" class="loadingImage hidden transisitionAllFast" />
												OK
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="table-row">
						<div class="table-cell"></div>
					</div>
				</div>

				<!-- Teilnahme -->
				<div class="content left table" id="ctnAttendance">
					<div class="introText">
						<div class="header">
							Verrate uns, ob du dabei sein wirst!
						</div>
						<div class="content">
							Bitte wähle unten aus einer von drei Optionen aus.
							<br />
							<span class="underline">Übrigens:</span>
							<?php
							if (getEmailValue() != "") {
								echo "Unten wird deine hinterlegte E-Mail Adresse angezeigt. Ist diese nicht mehr aktuell kannst du sie korrigieren.";
							} else {
								echo "Es ist noch keine Email von dir vorhanden.<br />Wenn du willst, kannst du diese unten eintragen. Damit bleibst du bei &Auml;nderungen auf dem neuesten Stand!";
							}
							?>
						</div>
					</div>
					<div class="table-row">
						<div class="table-cell vMiddle textCenter">
							<div class="table inlineBlock" id="cbAttendance">
								<div class="table-row">
									<div class="table-cell">
										<?php
										if ($attendance == 1) {
											echo "<div class=\"checkbox big transisitionAllSuperFast checked\" data-value=\"1\" id=\"cbYes\">";
										} else {
											echo "<div class=\"checkbox big transisitionAllSuperFast\" data-value=\"1\" id=\"cbYes\">";
										}
										?>
										<img class="cbLoading hidden left" src="assets/img/ajax_loader_bars.gif" />
										Ja
										</div>
									</div>
								</div>
								<div class="table-row">
									<div class="table-cell">
										<?php
										if ($attendance == 0) {
											echo "<div class=\"checkbox small left transisitionAllSuperFast checked\" data-value=\"0\" id=\"cbNo\">";
										} else {
											echo "<div class=\"checkbox small left transisitionAllSuperFast\" data-value=\"0\" id=\"cbNo\">";
										}
										?>
										<img class="cbLoading hidden left" src="assets/img/ajax_loader_bars.gif" />
										Nein
										</div>
										<?php
										if ($attendance == 2) {
											echo "<div class=\"checkbox small left transisitionAllSuperFast checked\" data-value=\"2\" id=\"cbMaybe\">";
										} else {
											echo "
<div class=\"checkbox small left transisitionAllSuperFast\" data-value=\"2\" id=\"cbMaybe\">";
										}
									?>
									<img class="cbLoading hidden left" src="assets/img/ajax_loader_bars.gif" />
										Vielleicht
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="table-row textCenter">
						<div class="table">
							<div class="table-row">
								<div class="table-cell vMiddle">
									<?php
									$currentEmail = getEmailValue();
									if (getEmailValue() != "") {
										echo "<input type=\"email\" class=\"bdTextfield big transisitionAllFast right \" value=\"" . $currentEmail . "\" id=\"tbEmail\" />";
									} else {
										echo "<input type=\"email\" class=\"bdTextfield big transisitionAllFast right inital\" value=\"Email\" id=\"tbEmail\" />";
									}
									?>
								</div>
								<div class="table-cell vMiddle">
									<div class="table">
										<div class="bdButton big table-cell transisitionAllSuperFast vMiddle" id="btnEmail">
											<img src="assets/img/ajax_loader_bars.gif" alt="Loading" id="emailLoader" class="loadingImage hidden transisitionAllFast" />
											OK
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="content_bg_wrapper">
						<div class="content_bg"></div>
					</div>
				</div>

				<!-- Versorgung -->
				<div class="content left table" id="ctnProvision">
					<div class="introText">
						<div class="header">
							Fressen, Saufen, Feiern!
						</div>
						<div class="content">
							Was wir alles bereitstellen werden:
							<ul>
								<li>
									25kg Spanferkel
								</li>
								<li>
									2x 30l Fassbier
								</li>
								<li>
									Diverse Kästen Bier
								</li>
								<li>
									Cola, Fanta, Sprite
								</li>
								<li>
									Orangensaft
								</li>
								<li>
									Wasser
								</li>
							</ul>
							Was von euch mitgebracht werden muss
							<ul>
								<li>
									Schnaps
								</li>
								<li>
									Spezielles
								</li>
								<li>
									Exotisches
								</li>
							</ul>
						</div>
					</div>
					<div class="table-row"></div>
					<div class="table-row">
						<div class="table-cell"></div>
					</div>
					<div class="content_bg_wrapper">
						<div class="content_bg"></div>
					</div>
				</div>

				<!-- Anfahrt -->
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

				<!-- Unterbringung -->
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