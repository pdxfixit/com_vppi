/**
 * @version     1.0.1
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
            var msg = new Object()
            msg.error = new Array();
            msg.error.push('Invalid Input.  Please make the listed corrections and try again.');
            if ($('jform_ml_number').hasClass('invalid')) {
                msg.error.push("The ML# must be between six and eight digits.");
            }
            if ($('jform_price').hasClass('invalid')) {
                msg.error.push("The price value must be a number.");
            }
            if ($('jform_zip_code').hasClass('invalid')) {
                msg.error.push("The zip code must be in the format XXXXX or XXXXX-XXXX.");
            }
            if ($('jform_acres').hasClass('invalid')) {
                msg.error.push("The acres value must be a number.");
            }
            if ($('jform_levels').hasClass('invalid')) {
                msg.error.push("The levels value must be a number.");
            }
            Joomla.renderMessages(msg);
            return false;
        }
    }
}
