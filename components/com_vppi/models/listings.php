<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modelitem');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

class VppiModelListings extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     *
     * @see        JController
     * @since      1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'street_address', 'a.street_address',
                'city', 'a.city',
                'state_prov', 'a.state_prov',
                'zip_code', 'a.zip_code',
                'ml_number', 'a.ml_number',
                'state', 'a.state',
                'ordering', 'a.ordering',
                'featured', 'a.featured',
                'sold', 'a.sold',
            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     * Note. Calling getState in this method will result in recursion.
     * @since    1.6
     */
    protected function populateState() {

        // Load the parameters.
        $params = JComponentHelper::getParams('com_vppi');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'asc');
    }

    /**
     * Build an SQL query to load the list data.
     * @return    JDatabaseQuery
     * @since    1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select($this->getState('list.select', 'a.*'))->from($db->quoteName('#__vppi_homes') . ' AS a');

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;

    }

    public function getPosters() {
        $posters = array();
        $posters['slide'] = array();
        $posters['thumb'] = array();
        $items = $this->getItems();
        foreach ($items as $item) {
            if (JFile::exists(JPATH_SITE . '/images/homes/' . (int)$item->id . '/poster.jpg')) {
                $posters['slide'][$item->id] = $item->id . '/poster.jpg';
            } else {
                $posters['slide'][$item->id] = '';
            }
            if (JFile::exists(JPATH_SITE . '/images/homes/' . (int)$item->id . '/poster-thumb.jpg')) {
                $posters['thumb'][$item->id] = $item->id . '/poster-thumb.jpg';
            } else {
                $posters['thumb'][$item->id] = '';
            }
        }

        return $posters;
    }
}
