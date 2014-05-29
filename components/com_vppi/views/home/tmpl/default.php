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

$document = JFactory::getDocument();
$document->addScript('/media/com_vppi/js/jquery.v1.5.js');
$document->addScript('/media/com_vppi/js/jquery.cycle.all.js');
$document->addStyleSheet('/media/com_vppi/css/vppi.css');
$document->addScriptDeclaration("
    $(document).ready(function() {
        $('#home-slideshow').cycle({
            fx:         'fade',
            speed:      500,
            timeout:    5000,
            next:       '#next',
            prev:       '#prev',
            pause:      1
        });
    });
");

if (!$this->item) {
    echo JText::_('COM_VPPI_ITEM_NOT_LOADED');

    return;
}
?>
<div id="home-listing">
    <?php if (!empty($this->poster)) { ?>
    <div id="home-slideshow" class="pics">
        <img src="/images/homes/<?php echo $this->item->id ?>/<?php echo $this->poster[0] ?>" width="100%" height="auto">
        <?php if (!empty($this->photos)) {
            foreach ($this->photos as $photo) { ?>
                <img src="/images/homes/<?php echo $this->item->id ?>/<?php echo $photo ?>" width="100%" height="auto">
        <?php
            }
        }
        ?>
    </div>
    <div id="next" class="arrow"><span>></span></div>
    <div id="prev" class="arrow"><span><</span></div>
    <div class="clear"></div><br />
    <?php
    }
    ?>
    <div id="basic-home-info" style="overflow: hidden;">
        <ul>
            <?php if (!empty($this->item->ml_number)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_ML_NUMBER'); ?>:</b>  <?php echo $this->item->ml_number; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->area)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_AREA'); ?>:</b>  <?php echo $this->item->area; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->elem_school)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_ELEM_SCHOOL'); ?>:</b>  <?php echo $this->item->elem_school; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->mid_school)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_MID_SCHOOL'); ?>:</b>  <?php echo $this->item->mid_school; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->high_school)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_HIGH_SCHOOL'); ?>:</b>  <?php echo $this->item->high_school; ?>
                </li>
            <?php } ?>
            <?php if ($this->item->short_sale == 0) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_SHORT_SALE'); ?>:</b> NO
                </li>
            <?php } elseif (!empty($this->item->short_sale) && $this->item->short_sale == 1) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_SHORT_SALE'); ?>:</b> YES
                </li>
            <?php } ?>
            <?php if ($this->item->bank_owned == 0) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_BANK_OWNED'); ?>:</b> NO
                </li>
            <?php } elseif (!empty($this->item->bank_owned) && $this->item->bank_owned == 1) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_BANK_OWNED'); ?>:</b> YES
                </li>
            <?php } ?>
            <?php if (!empty($this->item->waterfront)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_WATERFRONT'); ?>:</b>  <?php echo $this->item->waterfront; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->body_of_water)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_BODY_OF_WATER'); ?>:</b>  <?php echo $this->item->body_of_water; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->tax_per_year)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_TAX_PER_YEAR'); ?>:</b>  <?php echo $this->item->tax_per_year; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->tax_per_year)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_TAX_PROP_TYPE'); ?>:</b>  <?php echo $this->item->property_type; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->neighborhood_building)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_NBRHD_BLDG'); ?>:</b>  <?php echo $this->item->neighborhood_building; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->levels)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_LEVELS'); ?>:</b>  <?php echo $this->item->levels; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->garage)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_GARAGE'); ?>:</b>  <?php echo $this->item->garage; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->roof)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_ROOF'); ?>:</b>  <?php echo $this->item->roof; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->ext_description)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_EXT_DESC'); ?>:</b>  <?php echo $this->item->ext_description; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->mast_bed_level)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_MSTBDRM_LEVEL'); ?>:</b>  <?php echo $this->item->mast_bed_level; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->fireplace)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_FIREPLACE'); ?>:</b>  <?php echo $this->item->fireplace; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->basement_foundation)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_BSMT_FND'); ?>:</b>  <?php echo $this->item->basement_foundation; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->view)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_VIEW'); ?>:</b>  <?php echo $this->item->view; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->acres)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_ACRES'); ?>:</b>  <?php echo $this->item->acres; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->lot_size)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_LOT_SIZE'); ?>:</b>  <?php echo $this->item->lot_size; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->lot_dimensions)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_LOT_DIMENSIONS'); ?>:</b>  <?php echo $this->item->lot_dimensions; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->lot_description)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_LOT_DESCRIPTION'); ?>:</b>  <?php echo $this->item->lot_description; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->heat_fuel)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_HEAT_FUEL'); ?>:</b>  <?php echo $this->item->heat_fuel; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->cool)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_COOL'); ?>:</b>  <?php echo $this->item->cool; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->water_sewer)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_WATER_SEWER'); ?>:</b>  <?php echo $this->item->water_sewer; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->hot_water)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_HOT_WATER'); ?>:</b>  <?php echo $this->item->hot_water; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->zoning)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_ZONING'); ?>:</b>  <?php echo $this->item->zoning; ?>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="clear"></div>
    <?php if (!empty($this->item->remarks)) { ?>
    <div id="remarks">
        <p><b><?php echo JText::_('COM_VPPI_LBL_REMARKS'); ?>:</b></p>

        <p><?php echo $this->item->remarks; ?></p>
    </div>
    <?php
    }
    if (!empty($this->item->dining_room) || !empty($this->item->family_room) || !empty($this->item->living_room) || !empty($this->item->kitchen) || !empty($this->item->interior) || !empty($this->item->exterior) || !empty($this->item->accessibility) || !empty($this->item->green_certification) || !empty($this->item->energy_eff_features)) { ?>
    <div id="feature-home-info">
        <p><b><?php echo JText::_('COM_VPPI_LBL_FEATURES'); ?>:</b></p>
        <ul>
            <?php if (!empty($this->item->dining_room)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_DINING_ROOM'); ?>:</b>  <?php echo $this->item->dining_room; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->family_room)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_FAMILY_ROOM'); ?>:</b>  <?php echo $this->item->family_room; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->living_room)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_LIVING_ROOM'); ?>:</b>  <?php echo $this->item->living_room; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->kitchen)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_KITCHEN'); ?>:</b>  <?php echo $this->item->kitchen; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->interior)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_INTERIOR'); ?>:</b>  <?php echo $this->item->interior; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->exterior)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_EXTERIOR'); ?>:</b>  <?php echo $this->item->exterior; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->accessibility)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_ACCESSIBILITY'); ?>:</b>  <?php echo $this->item->accessibility; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->green_certification)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_GREEN_CERT'); ?>:</b>  <?php echo $this->item->green_certification; ?>
                </li>
            <?php } ?>
            <?php if (!empty($this->item->energy_eff_features)) { ?>
                <li>
                    <b><?php echo JText::_('COM_VPPI_LBL_ENERGY_EFF_FEATURES'); ?>:</b>  <?php echo $this->item->energy_eff_features; ?>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<div class="clear"></div>
</div>
