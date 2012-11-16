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

//Make sure this is a post request.
//NOTE: We exit with the same message everytime to not give away too much.
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Check if a name has been entered.
    if(!isset($_POST['name']) || empty($_POST['name'])) {
	exit("ERROR: Unable to authenticate!");
    }
    //Check if a password has been entered.
    if(!isset($_POST['password']) || empty($_POST['password'])) {
	exit("ERROR: Unable to authenticate!");
    }
    //Check if a queue file entry has been entered.
    if(!isset($_POST['entry']) || empty($_POST['entry'])) {
	exit("ERROR: Unable to authenticate!");
    }

    //Hash the password.
    $name = $_POST['name'];
    $hash = sha1($config['password_salt'] . $_POST['password']);
    //We take the basename, just to be sure.
    $entry = basename($_POST['entry']);
    
    //Receive the password file.
    $file = fopen($config['password_file'], 'r') or exit("ERROR: Unable to authenticate!");

    //Loop through the lines.
    while(($data = fgetcsv($file, 100, ',')) !== FALSE) {
	//Check if the name is equal.
	if($data[0] === $name) {
	    //Now check the password (hash).
	    if($data[1] === $hash) {
		//Everything is fine so delete the file, if it exists.
		$status = unlink($config['queue_dir'] . $entry);
		//Check the return status.
		if($status) {
		    exit("Done");
		} else {
		    exit("ERROR: Unable to execute operation!");
		}
	    }
	}
    }

    //Any other case means authentication failed.
    exit("ERROR: Unable to authenticate!");
}
