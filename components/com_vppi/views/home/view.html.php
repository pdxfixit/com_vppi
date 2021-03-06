<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

// No direct access
defined('_JEXEC') or die;

class VppiViewHome extends JViewLegacy {

    protected $address;
    protected $state;
    protected $item;
    protected $poster;
    protected $photos;

    function display($tpl = null) {
        $this->state = $this->get('State');
        $this->item = $this->get('Item');
        $this->poster = $this->get('Poster');
        $this->photos = $this->get('Photos');

        // standardized address
        $this->address = $this->item->name . ', ' . $this->item->city . ', ' . $this->item->state_prov . ' ' . $this->item->zip_code;

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        // remove any existing canonical links
        $app = JFactory::getApplication();
        $doc = JFactory::getDocument();
        foreach ($doc->_links as $k => $array) {
            if ($array['relation'] == 'canonical') {
                unset($doc->_links[$k]);
            }
        }
        // use our own canonical link generation process
        $doc->addHeadLink(rtrim(JUri::base(), '/') . JRoute::_('index.php?option=com_vppi&view=home&id=' . $app->input->getInt('id', 0) . '&Itemid=103'), 'canonical');

        parent::display($tpl);
    }

}
