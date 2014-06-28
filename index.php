<?php
require_once ('FirePHP.class.php');
require_once ('conf.php');
session_start();
ob_start();
?>
<!DOCTYPE html>
<html>
	<?php
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
			<div id="innerWrapper" class="transisitionAllMed darkGradient"
			<?php
			if (isset($_SESSION['usr']) && !empty($_SESSION['usr'])) {
				echo "style=\"margin-left: -1390px;\"";
			}
			?>
			>

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
							<div class="table inlineBlock">
								<div class="table-row">
									<div class="table-cell left">
										<input type="text" class="bdTextfield big inital transisitionAllFast" value="Nutzername" id="tbUser" />
									</div>
								</div>
								<div class="table-row smallTopMargin">
									<div class="table-cell">
										<input type="password" class="bdTextfield big inital transisitionAllFast" value="Passwort" id="tbPassword" />
										<img src="assets/img/ajax_loader_bars.gif" alt="Loading" id="pwLoader" class="loadingImage hidden transisitionAllFast" />
									</div>
									<div class="table-cell vMiddle">
										<div class="table">
											<div class="bdButton big table-cell transisitionAllSuperFast vMiddle" id="btnPassword">
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
						</div>
					</div>
					<div class="table-row">
						<div class="table-cell vMiddle textCenter">
							<div class="table inlineBlock">
								<div class="table-row">
									<div class="table-cell">
										<div class="checkbox big transisitionAllSuperFast" data-value="1" id="cbYes">
											Ja
										</div>
									</div>
								</div>
								<div class="table-row">
									<div class="table-cell">
										<div class="checkbox small left transisitionAllSuperFast" data-value="0" id="cbNo">
											Nein
										</div>
										<div class="checkbox small left transisitionAllSuperFast" data-value="2" id="cbMaybe">
											Vielleicht
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="table-row">
						<div class="table-cell"></div>
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