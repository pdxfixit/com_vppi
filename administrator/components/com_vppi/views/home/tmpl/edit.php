<?php
/**
 * @version     1.0.0
 * @package     com_vppi
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      PDXfixIT <info@pdxfixit.com> - http://www.pdxfixit.com
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root() . '/media/com_vppi/css/vppi.css');
$document->addScriptDeclaration("
    getScript('//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', function () {
        js = jQuery.noConflict();
        js(document).ready(function () {


            Joomla.submitbutton = function (task) {
                if (task == 'home.cancel') {
                    Joomla.submitform(task, document.getElementById('home-form'));
                }
                else {

                    if (task != 'home.cancel' && document.formvalidator.isValid(document.id('home-form'))) {

                        Joomla.submitform(task, document.getElementById('home-form'));
                    }
                    else {
                        alert('" . $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')) . "');
                    }
                }
            }
        });
    });")
?>

<form action="<?php echo JRoute::_('index.php?option=com_vppi&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="home-form" class="form-validate">
    <div class="width-60 fltlft">
        <fieldset class="adminform">
            <legend><?php echo JText::_('COM_VPPI_HOME'); ?></legend>
            <div>
                <p><b>Basic Information</b></p>
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('state'); ?>
                        <?php echo $this->form->getInput('state'); ?></li>

                    <li><?php echo $this->form->getLabel('id'); ?>
                        <?php echo $this->form->getInput('id'); ?></li>

                    <li><?php echo $this->form->getLabel('street_address'); ?>
                        <?php echo $this->form->getInput('street_address'); ?></li>

                    <li><?php echo $this->form->getLabel('city'); ?>
                        <?php echo $this->form->getInput('city'); ?></li>

                    <li><?php echo $this->form->getLabel('state_prov'); ?>
                        <?php echo $this->form->getInput('state_prov'); ?></li>

                    <li><?php echo $this->form->getLabel('zip_code'); ?>
                        <?php echo $this->form->getInput('zip_code'); ?></li>

                    <li><?php echo $this->form->getLabel('ml_number'); ?>
                        <?php echo $this->form->getInput('ml_number'); ?></li>

                    <li><?php echo $this->form->getLabel('area'); ?>
                        <?php echo $this->form->getInput('area'); ?></li>

                    <li><?php echo $this->form->getLabel('elem_school'); ?>
                        <?php echo $this->form->getInput('elem_school'); ?></li>

                    <li><?php echo $this->form->getLabel('mid_school'); ?>
                        <?php echo $this->form->getInput('mid_school'); ?></li>

                    <li><?php echo $this->form->getLabel('high_school'); ?>
                        <?php echo $this->form->getInput('high_school'); ?></li>

                    <li><?php echo $this->form->getLabel('short_sale'); ?>
                        <?php echo $this->form->getInput('short_sale'); ?></li>

                    <li><?php echo $this->form->getLabel('bank_owned'); ?>
                        <?php echo $this->form->getInput('bank_owned'); ?></li>

                    <li><?php echo $this->form->getLabel('waterfront'); ?>
                        <?php echo $this->form->getInput('waterfront'); ?></li>

                    <li><?php echo $this->form->getLabel('body_of_water'); ?>
                        <?php echo $this->form->getInput('body_of_water'); ?></li>

                    <li><?php echo $this->form->getLabel('tax_per_year'); ?>
                        <?php echo $this->form->getInput('tax_per_year'); ?></li>

                    <li><?php echo $this->form->getLabel('property_type'); ?>
                        <?php echo $this->form->getInput('property_type'); ?></li>

                    <li><?php echo $this->form->getLabel('neighborhood_building'); ?>
                        <?php echo $this->form->getInput('neighborhood_building'); ?></li>

                    <li><?php echo $this->form->getLabel('levels'); ?>
                        <?php echo $this->form->getInput('levels'); ?></li>

                    <li><?php echo $this->form->getLabel('garage'); ?>
                        <?php echo $this->form->getInput('garage'); ?></li>

                    <li><?php echo $this->form->getLabel('roof'); ?>
                        <?php echo $this->form->getInput('roof'); ?></li>

                    <li><?php echo $this->form->getLabel('ext_description'); ?>
                        <?php echo $this->form->getInput('ext_description'); ?></li>

                    <li><?php echo $this->form->getLabel('mast_bed_level'); ?>
                        <?php echo $this->form->getInput('mast_bed_level'); ?></li>

                    <li><?php echo $this->form->getLabel('fireplace'); ?>
                        <?php echo $this->form->getInput('fireplace'); ?></li>

                    <li><?php echo $this->form->getLabel('basement_foundation'); ?>
                        <?php echo $this->form->getInput('basement_foundation'); ?></li>

                    <li><?php echo $this->form->getLabel('view'); ?>
                        <?php echo $this->form->getInput('view'); ?></li>

                    <li><?php echo $this->form->getLabel('acres'); ?>
                        <?php echo $this->form->getInput('acres'); ?></li>

                    <li><?php echo $this->form->getLabel('lot_size'); ?>
                        <?php echo $this->form->getInput('lot_size'); ?></li>

                    <li><?php echo $this->form->getLabel('lot_dimensions'); ?>
                        <?php echo $this->form->getInput('lot_dimensions'); ?></li>

                    <li><?php echo $this->form->getLabel('lot_description'); ?>
                        <?php echo $this->form->getInput('lot_description'); ?></li>

                    <li><?php echo $this->form->getLabel('heat_fuel'); ?>
                        <?php echo $this->form->getInput('heat_fuel'); ?></li>

                    <li><?php echo $this->form->getLabel('cool'); ?>
                        <?php echo $this->form->getInput('cool'); ?></li>

                    <li><?php echo $this->form->getLabel('water_sewer'); ?>
                        <?php echo $this->form->getInput('water_sewer'); ?></li>

                    <li><?php echo $this->form->getLabel('hot_water'); ?>
                        <?php echo $this->form->getInput('hot_water'); ?></li>

                    <li><?php echo $this->form->getLabel('zoning'); ?>
                        <?php echo $this->form->getInput('zoning'); ?></li>
                </ul>
            </div>
            <div style="display: inline-block; margin-left: 50px">
                <p><b>Features</b></p>
                <ul class="adminformlist">
                    <li><?php echo $this->form->getLabel('dining_room'); ?>
                        <?php echo $this->form->getInput('dining_room'); ?></li>

                    <li><?php echo $this->form->getLabel('family_room'); ?>
                        <?php echo $this->form->getInput('family_room'); ?></li>

                    <li><?php echo $this->form->getLabel('living_room'); ?>
                        <?php echo $this->form->getInput('living_room'); ?></li>

                    <li><?php echo $this->form->getLabel('kitchen'); ?>
                        <?php echo $this->form->getInput('kitchen'); ?></li>

                    <li><?php echo $this->form->getLabel('interior'); ?>
                        <?php echo $this->form->getInput('interior'); ?></li>

                    <li><?php echo $this->form->getLabel('exterior'); ?>
                        <?php echo $this->form->getInput('exterior'); ?></li>

                    <li><?php echo $this->form->getLabel('accessibility'); ?>
                        <?php echo $this->form->getInput('accessibility'); ?></li>

                    <li><?php echo $this->form->getLabel('green_certification'); ?>
                        <?php echo $this->form->getInput('green_certification'); ?></li>

                    <li><?php echo $this->form->getLabel('energy_eff_features'); ?>
                        <?php echo $this->form->getInput('energy_eff_features'); ?></li>
                </ul>
            </div>

            <div>
                <b><?php echo $this->form->getLabel('remarks'); ?></b>
                <?php echo $this->form->getInput('remarks'); ?>
            </div>
        </fieldset>
    </div>

    <div class="width-40 fltrt">
        <?php echo JHtml::_('sliders.start', 'home-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

        <?php echo JHtml::_('sliders.panel', JText::_('JGLOBAL_FIELDSET_PUBLISHING'), 'publishing-details'); ?>

        <fieldset class="panelform">
            <ul class="adminformlist">
                <li><?php echo $this->form->getLabel('created_by'); ?>
                    <?php echo $this->form->getInput('created_by'); ?></li>
            </ul>
        </fieldset>

        <?php echo JHtml::_('sliders.end'); ?>

    </div>

    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
    <div class="clr"></div>

</form>
