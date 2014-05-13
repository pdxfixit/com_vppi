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
    window.addEvent('domready', function(){
       document.formvalidator.setHandler('mlnumber', function(value) {
          regex=/\d{8}/;
          return regex.test(value);
       });
    });");
?>
<script type="text/javascript">
    Joomla.submitbutton = function(task)
    {
        if (task == 'home.cancel' || document.formvalidator.isValid(document.id('home-form')))
        {
            Joomla.submitform(task, document.getElementById('home-form'));
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_vppi&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="home-form" class="form-validate">
    <div>
        <h1><?php echo JText::_('COM_VPPI_HOME'); ?></h1>
    </div>
    <div class="form-horizontal">
        <div class="row-fluid">
            <div class="row-fluid form-horizontal-desktop">
                <div class="span4">
                    <?php echo JLayoutHelper::render('joomla.edit.global', $this); ?>
                    <br/>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('id'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('street_address'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('street_address'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('city'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('city'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('state_prov'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('state_prov'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('zip_code'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('zip_code'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('ml_number'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('ml_number'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('area'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('area'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('elem_school'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('elem_school'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('mid_school'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('mid_school'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('high_school'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('high_school'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('short_sale'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('short_sale'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('bank_owned'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('bank_owned'); ?></div>
                    </div>
                </div>
                <div class="span4">
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('waterfront'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('waterfront'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('body_of_water'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('body_of_water'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('tax_per_year'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('tax_per_year'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('property_type'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('property_type'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('neighborhood_building'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('neighborhood_building'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('levels'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('levels'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('garage'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('garage'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('roof'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('roof'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('ext_description'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('ext_description'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('mast_bed_level'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('mast_bed_level'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('fireplace'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('fireplace'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('basement_foundation'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('basement_foundation'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('view'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('view'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('acres'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('acres'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('lot_size'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('lot_size'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('lot_dimensions'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('lot_dimensions'); ?></div>
                    </div>
                </div>
                <div class="span4">
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('lot_description'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('lot_description'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('heat_fuel'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('heat_fuel'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('cool'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('cool'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('water_sewer'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('water_sewer'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('hot_water'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('hot_water'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('zoning'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('zoning'); ?></div>
                    </div>
                    <div><b>Features</b></div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('dining_room'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('dining_room'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('family_room'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('family_room'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('living_room'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('living_room'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('kitchen'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('kitchen'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('interior'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('interior'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('exterior'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('exterior'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('accessibility'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('accessibility'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('green_certification'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('green_certification'); ?></div>
                    </div>
                    <div class="control-group">
                        <div class="control-label"><?php echo $this->form->getLabel('energy_eff_features'); ?></div>
                        <div class="controls"><?php echo $this->form->getInput('energy_eff_features'); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h3><?php echo $this->form->getLabel('remarks'); ?></h3>
        <div class="row-fluid form-horizontal-desktop">
            <div class="form-vertical">
                <?php echo $this->form->getInput('remarks'); ?>
            </div>
        </div>
    </div>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>
