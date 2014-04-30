<?php

/**
 * Fix uri paths found in string for hrefs and src attributes
 * @param  string $string The string to match the uri's inside
 * @return [type]         [description]
 */
function fixURIsToAbsolute($string)
{
	return preg_replace('/(src|href|action)= # start attribute
		("\s*?|\'\s*?|) # opening single or double quotes (followed maybe by space characters) or none
		(?!\w+:) # where doesnt start with a protocol
		([A-z-0-9].+?) # match the entire contents
		(\1|\s+|\>) # end attribute
		/ix', '$1=$2/$3$4', $string);
}
