/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

window.addEvent('domready', function () {
    document.formvalidator.setHandler('mlnumber',
        function (value) {
            regex = /\d{8}/;
            return regex.test(value);
        });
});