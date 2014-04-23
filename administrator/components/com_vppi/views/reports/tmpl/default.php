<?php
/**
 * @version     1.0.0
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

// no direct access
defined('_JEXEC') or die;
?>

<ul id="reports">
    <li><a href="<?php echo JRoute::_('index.php?option=com_vppi&view=report&id=1&format=csv'); ?>">Printed Roster</a></li>
    <li><a href="<?php echo JRoute::_('index.php?option=com_vppi&view=report&id=2&format=csv'); ?>">Volunteer List</a></li>
    <li><a href="<?php echo JRoute::_('index.php?option=com_vppi&view=report&id=3&format=csv'); ?>">Name Tags</a></li>
</ul>
