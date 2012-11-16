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

//Function that lists the queue files and returns them as an array.
//directory: The queue directory.
//Returns: an array containing the names of the queue files.
function get_queue($directory) {
    //NOTE: We don't use the allowed_types, since that would mean that disabling
    // a type makes moderation of already uploaded queue files impossible.
    $queue = glob($directory . "MAP*");
    $queue += glob($directory . "PACK*");
    $queue += glob($directory . "THEME*");

    return $queue;
}

//Function that returns the size of the queue.
//directory: The queue directory.
//Returns: The number of queue files.
function get_queue_size($directory) {
    $queue_size = count(get_queue($directory));
    
    //Return the queue size.
    return $queue_size;
}

