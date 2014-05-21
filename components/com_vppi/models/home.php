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

class VppiModelHome extends JModelItem {

    /**
     * Method to auto-populate the model state.
     * Note. Calling getState in this method will result in recursion.
     * @since    1.6
     */
    protected function populateState() {
        $app = JFactory::getApplication('com_vppi');

        $id = $app->getParams()->get('home_id');
        $this->setState('home.id', $id);

        // Load the parameters.
        $params = $app->getParams();
        $params_array = $params->toArray();
        if (isset($params_array['item_id'])) {
            $this->setState('home.id', $params_array['item_id']);
        }
        $this->setState('params', $params);

    }

    /**
     * Method to get home data.
     *
     * @param    integer    The id of the home.
     *
     * @return    mixed    Menu item data object on success, false on failure.
     */
    public function getItem($id = null) {

        if (empty($id)) {
            $id = $this->getState('home.id');
        }
        if ($this->_item === null) {
            $this->_item = array();
        }

        if (!isset($this->_item[$id])) {

            $db = $this->getDbo();
            $query = $db->getQuery(true);

            $query->select($this->getState(
                                'item.select', 'a.id, a.street_address, a.city, a.state_prov, a.zip_code, a.ml_number, a.area, ' .
                                             'a.elem_school, a.mid_school, a.high_school, a.short_sale, a.bank_owned, a.waterfront, ' .
                                             'a.body_of_water, a.tax_per_year, a.property_type, a.neighborhood_building, a.levels, ' .
                                             'a.garage, a.roof, a.ext_description, a.mast_bed_level, a.fireplace, a.basement_foundation, ' .
                                             'a.view, a.acres, a.lot_size, a.lot_dimensions, a.lot_description, a.heat_fuel, a.cool, ' .
                                             'a.water_sewer, a.hot_water, a.zoning, a.remarks, a.dining_room, a.family_room, ' .
                                             'a.living_room, a.kitchen, a.interior, a.exterior, a.accessibility, a.green_certification, ' .
                                             'a.energy_eff_features, a.state'
                           )
            );
            $query->from('#__vppi_home AS a');

            $query->where('a.id = ' . (int)$id);
            $query->where('a.state = 1');

            try {
                $db->setQuery($query);
                $data = $db->loadObject();
            } catch (Exception $e) {
                echo $e->getMessage();
            }

            if (empty($data)) {
                throw new Exception(JText::_('COM_VPPI_ERROR_HOME_DATA_NOT_FOUND'));
            }

            $this->_item[$id] = $data;
        }

        return $this->_item[$id];
    }

}
