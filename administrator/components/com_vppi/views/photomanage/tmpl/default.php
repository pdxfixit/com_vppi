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
$document->addScript('/media/jui/js/jquery.min.js');
$document->addScript('/media/jui/js/jquery-noconflict.js');
$document->addScript('/media/jui/js/jquery-migrate.min.js');
$document->addScriptDeclaration('
$(document).ready(function() {
    $("#image-sortlist").sortable();
    $("#image-sortlist").disableSelection();
});
');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canOrder = $user->authorise('core.edit.state', 'com_vppi');
$saveOrder = $listOrder == 'b.ordering';
?>
    <div class="row-fluid form-horizontal">
        <div class="span3">
            <form action="<?php echo JRoute::_('index.php?option=com_vppi&view=photomanage&layout=default&id=' . (int)$this->homeId); ?>" method="post" name="adminForm" id="home-images-form" enctype="multipart/form-data">
                <div>
                    <h1><?php echo JText::_('COM_VPPI_POSTER_IMAGE'); ?></h1>
                </div>
                <div class="form-vertical">
                    <div class="control-group">
                        <fieldset class="actions">
                            <label for="homeImageUpload"><?php echo JText::_('COM_VPPI_UPLOAD_POSTER_BUTTON_LABEL'); ?></label>
                            <input type="file" name="homeImageFiles" id="homeImageUpload" /><br />
                            <input type="submit" class="btn btn-primary" value="Upload Image" />
                        </fieldset>
                    </div>
                </div>
                <input type="hidden" name="poster" value="1" />
                <input type="hidden" name="task" value="photomanage.upload" />
                <?php echo JHtml::_('form.token'); ?>
            </form>
        </div>
        <?php
        if (!empty($this->poster['thumb'])) {
            if (!empty($this->poster['thumb'])) {
                ?>
                <div class="span9">
                    <img src="/images/homes/<?php echo (int)$this->homeId; ?>/poster-thumb.jpg" style="width: 250px">
                </div>
            <?php
            } else {
                ?>
                <div class="span9">
                    <img src="/media/com_vppi/images/image-not-available.jpg" style="width: 250px">
                </div>
            <?php
            }
        }
        ?>
    </div>
<?php if (!empty($this->poster['slide']) || !empty($this->poster['thumb'])) { ?>
    <p></p>
    <div class="row-fluid form-horizontal">
        <div class="span3">
            <form action="<?php echo JRoute::_('index.php?option=com_vppi&view=photomanage&layout=default&id=' . (int)$this->homeId); ?>" method="post" name="adminForm" id="home-images-form" enctype="multipart/form-data">
                <div>
                    <h1><?php echo JText::_('COM_VPPI_HOME_IMAGES'); ?></h1>
                </div>
                <div class="form-vertical">
                    <div class="control-group">
                        <fieldset class="actions">
                            <label for="homeImageUpload"><?php echo JText::_('COM_VPPI_UPLOAD_BUTTON_LABEL'); ?></label>
                            <?php // TODO: Make multiple image upload control use touch and not Ctrl/Shift button ?>
                            <input type="file" name="homeImageFiles[]" id="homeImageUpload" multiple /><br />
                            <input type="submit" class="btn btn-primary" value="Upload Multiple Images" />
                        </fieldset>
                    </div>
                </div>
                <input type="hidden" name="poster" value="0" />
                <input type="hidden" name="task" value="photomanage.upload" />
                <?php echo JHtml::_('form.token'); ?>
            </form>
        </div>
        <div class="span9 row-fluid form-horizontal">
            <?php
            if (!empty($this->photos['thumb'])) {
                // TODO: Make CSS Responsive
                // TODO: Create image ordering functionality
                ?>
                <form action="<?php echo JRoute::_('index.php?option=com_vppi&view=photomanage&layout=default&id=' . (int)$this->homeId); ?>" method="post" name="adminForm" id="home-images-delete-form">
                    <div class="row-fluid" style="overflow: hidden;">
                        <ul id="image-sortlist" class="ui-sortable">
                            <?php foreach ($this->photos['thumb'] as $photo) { ?>
                                <li class="ui-state-default ui-sortable-handle">
                                    <input style="display: inline;" type="checkbox" name="photo[]" value="<?php echo $photo; ?>">
                                    <img src="/images/homes/<?php echo (int)$this->homeId; ?>/<?php echo $photo; ?>">
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <br />
                    <div>
                        <input type="submit" class="btn btn-primary" value="Delete Images" />
                        <input type="hidden" name="task" value="photomanage.delete" />
                        <?php echo JHtml::_('form.token'); ?>
                    </div>
                </form>
            <?php
            }
            ?>
        </div>
    </div>
<?php
}
