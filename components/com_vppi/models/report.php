<?php
/**
 * @version     1.0.0
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

defined('_JEXEC') or die;

/*
 * List of reports
 * 1 => Printed Roster
 * 2 => Volunteer List
 * 3 => Name Tags
 */

class VppiModelReport extends JModel {

    public function getReport($id) {
        switch((int) $id) {
            case 1: // Printed Roster
                $query = "SELECT `name` AS 'Member Name'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 17 LIMIT 1), '') AS 'Business Name'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 8 LIMIT 1), '') AS 'Address'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 9 LIMIT 1), '') AS 'State'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 10 LIMIT 1), '') AS 'City'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 18 LIMIT 1), '') AS 'Zip'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 7 LIMIT 1), '') AS 'Phone'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 6 LIMIT 1), '') AS 'Mobile Phone'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 12 LIMIT 1), '') AS 'Web site'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 19 LIMIT 1), '') AS 'Email'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 20 LIMIT 1), '') AS 'Description'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 55 LIMIT 1), '') AS 'Member Since'
,IFNULL((SELECT 'Active' FROM `#__users` WHERE `id` = u.`id` AND EXISTS (SELECT * FROM `#__user_usergroup_map` WHERE `user_id` = u.`id` AND `group_id` = 11)), 'Not Active') AS 'Active Member'
FROM `#__users` AS u
WHERE `block` = 0";

                break;
            case 2: // Volunteer List
                $query = "SELECT `name` AS 'Name'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 7 LIMIT 1), '') AS 'Business Phone'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 19 LIMIT 1), '') AS 'Business Email'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 57 LIMIT 1), '') AS 'Program Development'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 58 LIMIT 1), '') AS 'Resources'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 59 LIMIT 1), '') AS 'ANLD Board'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 60 LIMIT 1), '') AS 'Newsletter'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 61 LIMIT 1), '') AS 'Web site'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 62 LIMIT 1), '') AS 'Winter Workshop'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 63 LIMIT 1), '') AS 'PR and Marketing'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 64 LIMIT 1), '') AS 'Summer Garden Tour'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 65 LIMIT 1), '') AS 'Communication'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 66 LIMIT 1), '') AS 'Member Services'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 67 LIMIT 1), '') AS 'ANLD Archives'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 68 LIMIT 1), '') AS 'ANLD Liason'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 69 LIMIT 1), '') AS 'Other'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 70 LIMIT 1), '') AS 'Other Description'
FROM `#__users` AS u
INNER JOIN `#__user_usergroup_map` AS m
ON u.id = m.user_id
WHERE u.block = 0
AND m.group_id = 11";

                break;
            case 3: // Name Tags
                $query = "SELECT `name` AS 'Name'
,IFNULL((SELECT `value` FROM `#__community_fields_values` WHERE `user_id` = u.`id` AND `field_id` = 17 LIMIT 1), '') AS 'Business Name'
FROM `#__users` AS u
INNER JOIN `#__user_usergroup_map` AS m
ON u.id = m.user_id
WHERE u.block = 0
AND m.group_id = 11";

                break;
        }

        try {
            $this->_db->setQuery($query);
            $result = $this->_db->loadAssocList();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }

        // prepend the headers to the data
        array_unshift($result, array_keys($result[0]));

        return $result;
    }

}
