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
				echo "<div class=\"navButton right transisitionAllFast pointer unselectable\" id=\"btnLogout\" onselectstart=\"return false;\" onmousedown=\"return false;\" unselectable=\"on\">Logout</div>";
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
                    document.write('<div id="innerWrapper" class="transisitionAllMed gapfiller_bg" style="margin-left:' + marVal + 'px">');
                }
			</script>
			<?php } else { ?>
			<div id="innerWrapper" class="transisitionAllMed gapfiller_bg">
				<?php } ?>

				<div class="gradient accentLine"></div>

				<!-- Login -->
				<div class="content left table contentBgLogin" id="ctnLogin">
					<div class="table-row">
						<div class="table-cell">
							<div class="introText">
								<div class="header">
									Anmeldung
								</div>
								<div class="content textBg">
									Bitte melde dich hier mit den Nutzerdaten an.
									<br />
									Hast du noch keine erhalten? Dann melde dich per E-Mail bei <a href="mailto:frankmur1983@hotmail.com?subject=Keine%20Zugangsdaten%20fuer%20die%20Geburtstagsseite">frankmur1983@hotmail.com</a>.
								</div>
							</div>
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
				<div class="content left table contentBgAttendance" id="ctnAttendance">
					<div class="table-row">
						<div class="table-cell">
							<div class="introText">
								<div class="header">
									Verrate uns, ob du dabei sein wirst!
								</div>
								<div class="content textBg">
									Es geht los am 09.08.2014 16:00 Uhr.
									<br />
									<br />
									<span class="underline">Übrigens:</span>
									<br />
									<?php
									if (getEmailValue() != "") {
										echo "Unten wird deine hinterlegte E-Mail Adresse angezeigt. Ist diese nicht mehr aktuell kannst du sie korrigieren.";
									} else {
										echo "Es ist noch keine Email von dir vorhanden.<br />Wenn du willst, kannst du diese unten eintragen. Damit bleibst du bei &Auml;nderungen auf dem neuesten Stand!";
									}
									?>
								</div>
							</div>
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
											echo "<div class=\"checkbox big transisitionAllSuperFast pointer\" data-value=\"1\" id=\"cbYes\">";
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
											echo "<div class=\"checkbox small left transisitionAllSuperFast pointer\" data-value=\"0\" id=\"cbNo\">";
										}
										?>
										<img class="cbLoading hidden left" src="assets/img/ajax_loader_bars.gif" />
										Nein
										</div>
										<?php
										if ($attendance == 2) {
											echo "<div class=\"checkbox small left transisitionAllSuperFast checked\" data-value=\"2\" id=\"cbMaybe\">";
										} else {
											echo "<div class=\"checkbox small left transisitionAllSuperFast pointer\" data-value=\"2\" id=\"cbMaybe\">";
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
						<div class="table bigButtonContainer vBottomDirty">
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
				<div class="content left table contentBgProvision" id="ctnProvision">
					<div class="table-row">
						<div class="table-cell">
							<div class="introText">
								<div class="header">
									Fressen, Saufen, Feiern!
								</div>
								<div class="content textBg">
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
											Säfte
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
				<div class="content left contentBgLocation" id="ctnLocation">
					<div class="table-row">
						<div class="table-cell">
							<div class="introText">
								<div class="header">
									Im Osten ist's am schönsten!
								</div>
								<div class="content textBg">
									Anreisen könnt ihr gerne schon am Freitag (08.08.2014).
									<br />
									Für Übernachtungsmöglichkeiten schaut im entsprechenden Bereich.
									<br />
									<br />
									Nutze das Google Maps Fenster um die Route berechnen zu lassen.
								</div>
							</div>
						</div>
					</div>
					<div class="table-row">
						<div class="table-cell textCenter googleMapsCell">
							<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d2525.7848796927465!2d12.74583!3d50.723929999999996!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47a735da8c937c0b%3A0xbffdb251c6b560fe!2sSchaftreibe+6C!5e0!3m2!1sde!2sde!4v1404047405688" frameborder="0" class="googleMapsFix"></iframe>
						</div>
					</div>
					<div class="content_bg_wrapper">
						<div class="content_bg"></div>
					</div>
				</div>

				<!-- Unterbringung -->
				<div class="content left contentBgAccommodation" id="ctnAccommodation">
					<div class="table-row">
						<div class="table-cell">
							<div class="introText">
								<div class="header">
									Zzz... Zzz... Zzz...
								</div>
								<div class="content textBg">
									Für alle Leute, die den langen Weg zu uns finden gibt es einige Schlafmöglichkeiten in unserer Umgebung!
									<br />
									<ul>
										<li>
											Bringt ein Zelt mit! Der Garten ist groß genug :D
										</li>
										<li>
											Privat bei Freunden in der näheren Umgebung
										</li>
										<li>
											<a target="_blank" href="https://www.google.com/maps/search/Pension;+Hotel/@50.7551347,12.744326,10z/am=t/data=!3m1!4b1!4m5!2m4!3m3!1sPension;+Hotel!2sSchaftreibe+6C,+09399+Niederw%C3%BCrschnitz,+Deutschland!3s0x47a735da8c937c0b:0xbffdb251c6b560fe?hl=de-DE">Pensionen und Hotels in der Umgebung</a>
										</li>
									</ul>
									<br />
									<br />
									Auch hier noch einmal:<br />Solltet ihr im Hotel / in einer Pension übernachten wollen könnt ihr vom
									<ul>
										<li>
											08.08.2014 - 10.08.2014 (2 Nächte) oder
										</li>
										<li>
											09.08.2014 - 10.08.2014 (1 Nacht) buchen.
										</li>
									</ul>
									<br />
									<br />
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
			</div>
		</div>
		<div id="fixedThree" class="crayon big verticalText fixed">
			3
		</div>
		<div id="fixedZero" class="crayon big verticalText fixed">
			0
		</div>
		<div id="fixedYear" class="crayon normal fixed">

		</div>
	</body>
</html>