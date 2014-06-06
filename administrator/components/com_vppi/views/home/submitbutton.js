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
            msg.error.push('There was an invalid input.  Make the listed corrections and try again.');
            if ($('jform_ml_number').hasClass('invalid')) {
                msg.error.push("Please make sure that the ML# is between six and eight digits long");
            }
            if ($('jform_price').hasClass('invalid')) {
                msg.error.push("Please make sure that the price value is a number with no commas");
            }
            if ($('jform_zip_code').hasClass('invalid')) {
                msg.error.push("Please make sure that the zip is in the format XXXXX or XXXXX-XXXX.");
            }
            if ($('jform_acres').hasClass('invalid')) {
                msg.error.push("Please make sure that the acres value is a number (values will be rounded to the second decimal place)");
            }
            if ($('jform_levels').hasClass('invalid')) {
                msg.error.push("Please make sure that the levels value is an integer");
            }
            Joomla.renderMessages(msg);
            return false;
        }
    }
}
