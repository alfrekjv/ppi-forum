<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Text Helper Class Extended.
 *
 * @package    Qanda
 * @subpackage Helper
 */
class text extends text_Core
{

    /**
     * Slugify a String of Words
     *
     * Modifies a string to remove al non ASCII characters and spaces.
     * 
     * @link    http://snipplr.com/view.php?codeview&id=22741
     */
    /***travo20100131: Deprecated as it does same thing as url::title();
    static public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }
    */

    /**
     * Truncates text.
     *
     * Cuts a string to the length of $length and replaces the last characters
     * with the ending if the text is longer than length.
     *
     * REF: http://api11.cakephp.org/text_8php-source.html
     * 
     * @param string  $text String to truncate.
     * @param integer $length Length of returned string, including ellipsis.
     * @param string  $ending Ending to be appended to the trimmed string.
     * @param boolean $exact If false, $test will not be cut mid-word
     * @return string Trimmed string.
     * @access public
     */
    function truncate($text, $length, $ending = '...', $exact = true)
    {
        if (strlen($text) <= $length)
        {
            return $text;
        }
        else
        {
            $truncate = substr($text, 0, $length - strlen($ending));
            if ($exact == FALSE)
            {
                $spacepos = strrpos($truncate, ' ');
                if (isset($spacepos))
                {
                    return substr($truncate, 0, $spacepos) . $ending;
                }
            }
            return $truncate . $ending;
        }
    }



}//END class