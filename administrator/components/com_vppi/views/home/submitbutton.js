/**
 * @version     1.0.0
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

Joomla.submitbutton = function (task) {
    if (task == '') {
        return false;
    }
    else {
        var isValid = true;
        if (task != 'home.cancel') {
            if (!document.formvalidator.isValid(document.id('home-form'))) {
                isValid = false;
            }
        }

        if (isValid) {
            Joomla.submitform(task, document.getElementById('home-form'));
            return true;
        }
        else {
            alert(Joomla.JText._('COM_VPPI_ERROR_MESSAGE',
                'Some values are unacceptable'));
            return false;
        }
    }
}
