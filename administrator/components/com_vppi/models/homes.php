<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class VppiModelHomes extends JModelList {

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
                'area', 'a.area',
                'elem_school', 'a.elem_school',
                'mid_school', 'a.mid_school',
                'high_school', 'a.high_school',
                'short_sale', 'a.short_sale',
                'bank_owned', 'a.bank_owned',
                'waterfront', 'a.waterfront',
                'body_of_water', 'a.body_of_water',
                'tax_per_year', 'a.tax_per_year',
                'property_type', 'a.property_type',
                'neighborhood_building', 'a.neighborhood_building',
                'levels', 'a.levels',
                'garage', 'a.garage',
                'roof', 'a.roof',
                'ext_description', 'a.ext_description',
                'mast_bed_level', 'a.mast_bed_level',
                'fireplace', 'a.fireplace',
                'basement_foundation', 'a.basement_foundation',
                'view', 'a.view',
                'acres', 'a.acres',
                'lot_size', 'a.lot_size',
                'lot_dimensions', 'a.lot_dimensions',
                'lot_description', 'a.lot_description',
                'heat_fuel', 'a.heat_fuel',
                'cool', 'a.cool',
                'water_sewer', 'a.water_sewer',
                'how_water', 'a.hot_water',
                'zoning', 'a.zoning',
                'remarks', 'a.remarks',
                'dining_room', 'a.dining_room',
                'family_room', 'a.family_room',
                'living_room', 'a.living_room',
                'kitchen', 'a.kitchen',
                'interior', 'a.interior',
                'exterior', 'a.exterior',
                'accessibility', 'a.accessibility',
                'green_certification', 'a.green_certification',
                'energy_eff_features', 'a.energy_eff_features',
                'state', 'a.state',
                'ordering', 'a.ordering',
                'featured', 'a.featured',
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
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        // Load the parameters.
        $params = JComponentHelper::getParams('com_vppi');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param    string $id A prefix for the store id.
     *
     * @return    string        A store id.
     * @since    1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id .= ':' . $this->getState('filter.search');
        $id .= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
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
        $user = JFactory::getUser();

        // Select the required fields from the table.
        $query->select(
              $this->getState(
                   'list.select', 'a.*'
              )
        );
        $query->from($db->quoteName('#__vppi_home') . ' AS a');

        // Join over the users for the checked out user.
        $query->select('uc.name AS editor');
        $query->join('LEFT', '#__users AS uc ON uc.id=a.checked_out');

        // Filter by published state
        $published = $this->getState('filter.state');
        if (is_numeric($published)) {
            $query->where('a.state = ' . (int)$published);
        } elseif ($published === '') {
            $query->where('(a.state IN (0, 1))');
        }

        // Filter by search in ml_number
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int)substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('(a.ml_number LIKE ' . $search . ')');
            }
        }

        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }
}
