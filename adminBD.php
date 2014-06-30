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
            function adminMessage($str) {
                $('.messages').children('.msgContent').html($str);
            }


            $(document).ready(function() {
                function btnConfirmAdmin() {
                    adminMessage('Please wait');

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
                            $('#adminLogin').fadeOut(400, function() {
                                adminMessage('');
                                $('#adminContent').html(result).fadeIn();
                            });
                        }).fail(function() {
                            adminMessage('User not authorized');
                        });
                    }
                }

                function btnNewUserClick() {
                    var tbNewUserFirstName = $('#tbNewUserFirstName'), tbNewUserLastName = $('#tbNewUserLastName'), tbNewUserUsername = $('#tbNewUserUsername'), tbNewUserPasswordOne = $('#tbNewUserPasswordOne'), tbNewUserPasswordTwo = $('#tbNewUserPasswordTwo');
                    var check = (tbNewUserFirstName.bdValidate() && tbNewUserLastName.bdValidate() && tbNewUserUsername.bdValidate() && tbNewUserPasswordOne.bdValidate() && tbNewUserPasswordTwo.bdValidate() && (tbNewUserPasswordOne.val() === tbNewUserPasswordTwo.val()));
                    var tbNewUserFirstNameValue = tbNewUserFirstName.val(), tbNewUserLastNameValue = tbNewUserLastName.val(), tbNewUserUsernameValue = tbNewUserUsername.val(), tbNewUserPasswordOneValue = tbNewUserPasswordOne.val(), tbNewUserPasswordTwoValue = tbNewUserPasswordTwo.val();

                    adminMessage('Please wait');
                    if (check) {
                        $.ajax({
                            url : "././dbConnectController.php",
                            type : "POST",
                            data : ( {
                                action : "addNewUser",
                                firstName : tbNewUserFirstNameValue,
                                lastName : tbNewUserLastNameValue,
                                userName : tbNewUserUsernameValue,
                                pw : tbNewUserPasswordOneValue
                            })
                        }).done(function(result) {
                            adminMessage(result);
                        }).fail(function(result) {
                            adminMessage(result.statusText);
                        }).always(function() {

                        });
                    }

                }


                $('#confirmAdmin').on('click', btnConfirmAdmin);
                $('body').on('click', '#btnNewUser', btnNewUserClick)
            });
		</script>
		<div class="admin">
			<div class="messages">
				Messages
				<div class="msgContent"></div>
			</div>
			<div id="adminLogin" class="padding10px" style="width: 250px; border: 1px solid #111; background: #fff;">
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
			<div id="adminContent" class="padding10px adminContent">

			</div>
		</div>
	</body>
</html>