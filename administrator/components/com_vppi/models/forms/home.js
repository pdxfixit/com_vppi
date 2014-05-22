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

window.addEvent('domready', function () {
    document.formvalidator.setHandler('zipcode',
        function (value) {
            regex = /\d{5}(?:[-\s]\d{4})?/;
            return regex.test(value);
        });
});

window.addEvent('domready', function () {
    document.formvalidator.setHandler('levels',
        function (value) {
            regex = /\d{1,2}/;
            return regex.test(value);
        });
});

window.addEvent('domready', function () {
    document.formvalidator.setHandler('acres',
        function (value) {
            regex = /(?:\d*\.)?\d+/;
            return regex.test(value);
        });
});
