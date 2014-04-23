<?php
/**
 * @version     1.0.0
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

// No direct access
defined('_JEXEC') or die;

class VppiViewReport extends JViewLegacy {

    private $reports = array( 1 => "Printed Roster",
                            2 => "Volunteer List",
                            3 => "Name Tags");

    /**
     * Send a CSV file.
     */
    public function display($tpl = null) {
        $id = JFactory::getApplication()->input->get('id');
        $filename = urlencode($this->reports[$id] . '.' . date('Ymd') . '.csv');

        $model = $this->getModel('report', 'vppi');
        $data = $model->getReport($id);

        $stream = fopen('php://output', 'w');
        ob_start();
        foreach ($data as $row) {
            fputcsv($stream, $row);
        }
        $content = ob_get_clean();

        // JDocumentRaw would send a MIME type of text/html, if we let it.
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        header('Content-Transfer-Encoding: binary');

        jexit($content);
    }

}
