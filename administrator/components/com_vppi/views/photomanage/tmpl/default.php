<?php
/**
 * @version     1.0.1
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root() . 'media/com_vppi/css/vppi.css');
?>
<form action="<?php echo JRoute::_('index.php?option=com_vppi&view=photomanage&layout=default&id=' . (int)$this->item->id); ?>" method="post" name="adminForm" id="home-images-form" enctype="multipart/form-data">
<div>
    <h1><?php echo JText::_('COM_VPPI_HOME_IMAGES'); ?></h1>
</div>
<div class="form-vertical">
    <div class="control-group">
        <fieldset class="actions">
            <label for="homeImageUpload"><?php echo JText::_('COM_VPPI_UPLOAD_BUTTON_LABEL') ?></label>
            <input type="file" name="homeImageFiles[]" id="homeImageUpload" class="multi" /><br/>
            <input type="submit" class="btn btn-primary" value="Upload Images" />
        </fieldset>
    </div>
</div>
    <input type="hidden" name="task" value="photomanage.upload" />
<?php echo JHtml::_('form.token'); ?>
</form>
