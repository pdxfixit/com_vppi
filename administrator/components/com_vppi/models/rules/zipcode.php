<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

defined('_JEXEC') or die();

// import Joomla formrule library
jimport('joomla.form.formrule');

/**
 * Form Rule class for the Joomla Framework.
 */
class JFormRuleZipcode extends JFormRule {

    /**
     * The regular expression.
     * @access      protected
     * @var         string
     * @since       2.5
     */
    protected $regex = '\d{5}(?:[-\s]\d{4})?';
}
