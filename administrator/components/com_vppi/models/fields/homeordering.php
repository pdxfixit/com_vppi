<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Supports an HTML select list of categories
 */
class JFormFieldHomeOrdering extends JFormFieldList {

    /**
     * The form field type.
     * @var        string
     * @since    1.6
     */
    protected $type = 'homeordering';

    /**
     * Method to get the list of homes
     * @return  array  The field option objects
     * @since   1.7
     */
    protected function getOptions() {
        $options = array();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true)
                    ->select('a.ordering AS value, CONCAT (a.ordering, ". ", a.street_address) AS text')
                    ->from('#__vppi_home AS a')
                    ->order('ordering');

        // Get the options.
        $db->setQuery($query);

        try {
            $options = $db->loadObjectList();
        } catch (RuntimeException $e) {
            throw new Exception($e->getMessage());
        }

        // Merge any additional options in the XML definition.
        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }

    /**
     * Method to get the field input markup
     * @return  string  The field input markup.
     * @since   1.7
     */
    protected function getInput() {
        if ($this->form->getValue('id', 0) == 0) {
            return '<span class="readonly">' . JText::_('COM_VPPI_HOME_ITEM_ORDERING_TEXT') . '</span>';
        } else {
            return parent::getInput();
        }
    }
}

 