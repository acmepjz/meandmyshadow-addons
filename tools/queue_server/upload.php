<?php
/*
 * Copyright (C) 2012 Me and My Shadow
 *
 * This file is part of Me and My Shadow.
 *
 * Me and My Shadow is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Me and My Shadow is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Me and My Shadow.  If not, see <http://www.gnu.org/licenses/>.
 */

//Load the configuration file.
include('config.php');
include('queue.php');

//The data array that will be put in the header of the queue files.
$data['type'] = '';
$data['name'] = '';
$data['description'] = '';
$data['update'] = '0';
$data['username'] = '';
$data['email'] = '';
$data['remember'] = '0';

//DEBUG: Print the post and files arrays.
if($config['debug']) {
    print_r($_POST);
    print_r($_FILES);
}

//Check if the queue is full.
if(get_queue_size($config['queue_dir']) >= $config['max_queue_size']) {
    exit("ERROR: Queue is full, please try again later.");
}

//NOTE: Make sure it's a post request???

//Validate the (user) input.
//Validate the type.
if(!isset($_POST['type']) || empty($_POST['type'])) {
    exit("ERROR: Upload type isn't set!");
} else {
    //Check if the type is allowed.
    if(!in_array($_POST['type'], $config['allowed_types'])) {
	exit("ERROR: Upload type isn't allowed!");
    }
}
//Fill the data array.
$data['type'] = $_POST['type'];

//Validate the name.
if(!isset($_POST['name']) || empty($_POST['name'])) {
    exit("ERROR: The name field can't be empty!");
} else {
    //The name field is filled, check the length.
    if(strlen($_POST['name']) > $config['max_name_length']) {
	exit("ERROR: The name is too long, only " . $config['max_name_length'] . " characters allowed!");
    }
}
//Fill the data array.
$data['name'] = $_POST['name'];

//Validate the description.
if(!isset($_POST['description']) || empty($_POST['description'])) {
    exit("ERROR: The description field can't be empty!");
} else {
    //The description field is filled, check the length.
    if(strlen($_POST['description']) > $config['max_description_length']) {
	exit("ERROR: The description is too long, only " . $config['max_description_length'] . " characters allowed!");
    }
}
//Fill the data array.
$data['description'] = json_encode($_POST['description']);

//Check if update is set, and therefor checked by the user.
if(isset($_POST['update']) && $_POST['update'] == 1) {
    $data['update'] = 1;
}

//Validate the user name.
if(!isset($_POST['username']) || empty($_POST['username'])) {
    exit("ERROR: Your name field can't be empty!");
} else {
    //The username field is filled, check the length.
    if(strlen($_POST['username']) > $config['max_username_length']) {
	exit("ERROR: Your name is too long, only " . $config['max_username_length'] . " characters allowed!");
    }
}
//Fill the data array.
$data['username'] = $_POST['username'];

//Validate the email.
//NOTE: We don't check if it's an actual email address, if not we simply moderate it out. :P
if(!isset($_POST['email']) || empty($_POST['email'])) {
    exit("ERROR: Your email field can't be empty!");
} else {
    //The email field is filled, check the length.
    if(strlen($_POST['email']) > $config['max_email_length']) {
	exit("ERROR: Your email is too long, only " . $config['max_email_length'] . " characters allowed!");
    }
}
//Fill the data array.
$data['email'] = $_POST['email'];

//Now we check if the file is attached.
if(!isset($_FILES['file']) || empty($_FILES['file'])) {
    exit("ERROR: No file attached.");
}

//TODO: Validate file?

//Create a queue file in the queue folder.
$queuefile = tempnam($config['queue_dir'], $_POST['type'] . '-');

//Open the file in write mode.
chmod($queuefile, 0755);
$handle = fopen($queuefile, "w");

fwrite($handle, "type=" . $data['type'] . "\n");
fwrite($handle, "name=" . $data['name'] . "\n");
fwrite($handle, "description=" . $data['description'] . "\n");
fwrite($handle, "update=" . $data['update'] . "\n");
fwrite($handle, "username=" . $data['username'] . "\n");
fwrite($handle, "email=" . $data['email'] . "\n");


//Write the delimiter.
fwrite($handle, "--\n");

//Write the content of the uploaded file.
$uploadfile = file_get_contents($_FILES['file']['tmp_name']);
fwrite($handle, $uploadfile);

//And close the file.
fclose($handle);
