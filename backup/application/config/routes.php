<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * The routing configurations of the Qanda.
 *
 * @package Qanda
 */

/**
 * Sets the default route
 */
$config['_default'] = 'questions/browse';

/**
 * Sets Custom Question Routes
 */
$config['questions/']                           = 'questions/browse/page/1/active';
$config['questions/unanswered']                 = 'questions/browse/page/1/unanswered';
$config['questions/unanswered/page/([0-9]+)']   = 'questions/browse/page/$1/unanswered';
$config['questions/ask']                        = 'questions/create';
