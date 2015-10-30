<?php
/*
============================
QuickCaptcha 1.0 - A bot-thwarting text-in-image web tool.
Copyright (c) 2006 Web 1 Marketing, Inc.

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
============================
Pretty much everything that you'll need to change/adjust
should be right here in this file.
============================
*/

// This string contains allowable characters for the image.
// To reduce confusion, zero and the letter 'o' have been removed,
// and QuickCaptcha is NOT case-sensitive.
$acceptedChars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';

// Number of characters in image.
$stringlength = 5;

// Where to go when the correct / incorrect code is entered.
$success = "success.html";
$failure = "failure.html";

// A value between 0 and 100 describing how much color overlap
// there is between text and other objects.  Lower is more
// secure against bots, but also harder to read.
$contrast = 60;

// Various obfuscation techniques.
$num_polygons = 3; // Number of triangles to draw.  0 = none
$num_ellipses = 6;  // Number of ellipses to draw.  0 = none
$num_lines = 0;  // Number of lines to draw.  0 = none
$num_dots = 0;  // Number of dots to draw.  0 = none

$min_thickness = 2;  // Minimum thickness in pixels of lines
$max_thickness = 8;  // Maximum thickness in pixles of lines
$min_radius = 5;  // Minimum radius in pixels of ellipses
$max_radius = 15;  // Maximum radius in pixels of ellipses

// How opaque should the obscuring objects be. 0 is opaque, 127
// is transparent.
$object_alpha = 75;
?>