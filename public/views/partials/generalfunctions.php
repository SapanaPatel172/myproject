<?php
//display messages error or success
function msg(){
display_msg('error');
display_msg('success');
display_msg('create_success');
display_msg('update_success');
display_msg('delete_success');
display_msg('create_error');
display_msg('delete_error');
display_msg('update_error');
display_msg('msg_error');
display_msg('msg_success');
}
//display error or success message
function display_msg($msgType)
{
    $alert_types = [
        'update_success' => 'alert-success',
        'error' => 'alert-danger',
        'success' => 'alert-success',
        'msg_error' => 'alert-danger',
        'msg_success' => 'alert-success',
        'delete_success' => 'alert-success',
        'create_success' => 'alert-success',
        'delete_error' => 'alert-danger',
        'create_error' => 'alert-danger',
        'update_error' => 'alert-danger',
    ];

    if (isset($_SESSION[$msgType]) && !empty($_SESSION[$msgType])) {
        $alert_type = $alert_types[$msgType] ?? ''; // Default to an empty string if type is not found

        if (!empty($alert_type)) {
?>
            <div class="alert <?= $alert_type ?>">
                <ul>
                    <?php foreach ($_SESSION[$msgType] as $msg) { ?>
                        <h6>
                            <li><?= $msg; ?></li>
                        </h6>
                    <?php } ?>
                </ul>
            </div>
<?php
            unset($_SESSION[$msgType]);
        }
    }
}



function generatePassword()
{
    $length = 8;
    $specialChars = '!@#$%^&*()-_+=';
    $digits = '0123456789';

    // Ensure at least one special character and one digit
    $password = '';
    $password .= $specialChars[rand(0, strlen($specialChars) - 1)];
    $password .= $digits[rand(0, strlen($digits) - 1)];

    // Generate remaining characters
    $remainingLength = $length - 2;
    $allowedChars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $allowedChars .= $specialChars;
    $allowedChars .= $digits;

    for ($i = 0; $i < $remainingLength; $i++) {
        $password .= $allowedChars[rand(0, strlen($allowedChars) - 1)];
    }

    // Shuffle the password characters
    $password = str_shuffle($password);

    return $password;
}
?>