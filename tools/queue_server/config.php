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

//Boolean if debug mode is enabled.
//NOTE: Always keep debug mode false on a live server.
$config['debug'] = false;
//The password file.
$config['password_file'] = '/srv/www/htdocs/shadow';
//The salt for hashing the passwords.
//NOTE: This needs to be changed on a live server.
$config['password_salt'] = 'ChangeThis';
//List of allowed upload types.
//NOTE: This will probably never change, but is here for easy adding/disabling.
$config['allowed_types'] = array('MAP', 'PACK', 'THEME');
//The location on the server where the queue dir is located.
//NOTE: This dir needs to be writable for the script.
$config['queue_dir'] = '/srv/www/htdocs/queue/'; 
//The maximum number of items allowed in the queue at once.
$config['max_queue_size'] = 5;

//The maximum allowed length for the name of the upload.
$config['max_name_length'] = 30;
//The maximum allowed lengt for the description.
$config['max_description_length'] = 500;
//The maximum allowed lengt for the uploader's name.
$config['max_username_length'] = 30;
//The maximum allowed lengt for the uploader's email.
$config['max_email_length'] = 50;
