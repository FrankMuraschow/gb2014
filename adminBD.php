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
		<script type="text/javascript">
            $(document).ready(function() {
                function btnConfirmAdmin() {

                    var tbAdminUser = $('#tbAdminUser'), tbAdminPw = $('#tbAdminPw'), check = (tbAdminUser.bdValidate() && tbAdminPw.bdValidate()), adminUserVal = tbAdminUser.val(), adminPwVal = tbAdminPw.val();

                    if (check) {
                        $.ajax({
                            url : "././dbConnectController.php",
                            type : "POST",
                            data : ( {
                                action : "validateAdmin",
                                usr : adminUserVal,
                                pw : adminPwVal
                            })
                        }).done(function(result) {
                            $('#adminContent').html(result);
                        });
                    }
                }

                $('#confirmAdmin').on('click', btnConfirmAdmin);
            });

		</script>
		<div class="padding10px" style="width: 250px; border: 1px solid #111; background: #fff;">
			<fieldset>
				<legend>
					Zugangsdaten
				</legend>
				<label class="label" for="adminUser">Nutzer:</label>
				<input type="text" id="tbAdminUser" style="border: 1px solid #111;" />
				<label class="label" for="adminPw">Passwort: </label>
				<input type="text" id="tbAdminPw"  style="border: 1px solid #111;"/>
			</fieldset>
			<div class="smallButton" id="confirmAdmin" style="border: 1px solid #111;">
				OK
			</div>
		</div>
		<div id="adminContent" class="padding10px" style="width: 250px; border: 1px solid #111; background: #fff;">

		</div>
	</body>
</html>