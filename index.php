<?php
//set default values
$name = '';
$email = '';
$phone = '';
$message = 'Enter some data and click on the Submit button.';

//process
$action = filter_input(INPUT_POST, 'action');

switch ($action) {
    case 'process_data':
        $name = filter_input(INPUT_POST, 'name');
        $email = filter_input(INPUT_POST, 'email');
        $phone = filter_input(INPUT_POST, 'phone');


        // trim the spaces from the start and end of all data
        $name = trim($name);
        $email = trim($email);
        $phone = trim($phone);
        // validate that name is not empty
        if (empty($name)) {
            $message = 'Please enter your name.';
            break;
        };
        // capitalize the first letters only of the name
        $name = ucwords($name);

        // get first name from complete name  
        $i = strpos($name, ' ');
        if ($i === false) {
            $first_name = $name;
        } else {
            $first_name = substr($name, 0, $i);
        }

        //get last name
        $last_name_start = strrpos($name, ' ') + 1;
        $last_name = substr($name, $last_name_start); 

        //get middle name
        //list($var1,$var2,$var3) = explode(' ', $name);
        //if ($var3 === false) {
        //    $middle_name = null;     
        //} else {
        //    $middle_name = $var2;
        //}

        // validate email
        if (empty($email)) {
            $message = 'You must enter an email address.';
            break;
        } else if(strpos($email, '@') === false) {
            $message = 'The email address must contain an @ sign.';
            break;
        } else if(strpos($email, '.') === false) {
            $message = 'The email address must contain a dot character.';
            break;
        }

        // remove common formatting characters from the phone number
        $phone = str_replace('-', '', $phone);
        $phone = str_replace('(', '', $phone);
        $phone = str_replace(')', '', $phone);
        $phone = str_replace(' ', '', $phone);

        // validate the phone number
        if (strlen($phone) < 7) {
            $message = 'The phone number must contain at least seven digits.';
            break;
        }

        // format the phone number
        if (strlen($phone) == 7) {
            $part1 = substr($phone, 0, 3);
            $part2 = substr($phone, 3);
            $phone = $part1 . '-' . $part2;
        } else {
            $part1 = substr($phone, 0, 3);
            $part2 = substr($phone, 3, 3);
            $part3 = substr($phone, 6);
            $phone = $part1 . '-' . $part2 . '-' . $part3;
        }

        // format the message
        $message =
            "Hello $first_name,\n\n" .
            "Thank you for entering this data:\n\n" .
            "Name: $name\n" .
            "Email: $email\n" .
            "Phone: $phone\n\n".
            "First Name: $first_name\n".
            "Middle Name: \n".
            "Last Name: $last_name\n\n".
            "Area Code: $part1\n".
            "Phone number: $part2-$part3\n";
        break;
}
include 'string_tester.php';

?>