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
JHtml::_('behavior.multiselect');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root() . 'media/com_vppi/css/vppi.css');

$user = JFactory::getUser();
$userId = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$canOrder = $user->authorise('core.edit.state', 'com_vppi');
$saveOrder = $listOrder == 'a.ordering';
if ($saveOrder) {
    $saveOrderingUrl = 'index.php?option=com_vppi&task=homes.saveOrderAjax&tmpl=component';
    JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
$sortFields = $this->getSortFields();
?>
<script type="text/javascript">
    Joomla.orderTable = function () {
        table = document.getElementById("sortTable");
        direction = document.getElementById("directionTable");
        order = table.options[table.selectedIndex].value;
        if (order != '<?php echo $listOrder; ?>') {
            dirn = 'asc';
        }
        else {
            dirn = direction.options[direction.selectedIndex].value;
        }
        Joomla.tableOrdering(order, dirn, '');
    }
</script>
<form action="<?php echo JRoute::_('index.php?option=com_vppi&view=homes'); ?>" class="form-validate" method="post" name="adminForm" id="adminForm">
    <?php if (!empty($this->sidebar)) { ?>
    <div id="j-sidebar-container" class="span2">
        <?php echo $this->sidebar; ?>
    </div>
    <div id="j-main-container" class="span10">
        <?php } else { ?>
        <div id="j-main-container">
            <?php
            }
            ?>
            <div id="filter-bar" class="btn-toolbar">
                <div class="filter-search btn-group pull-left">
                    <label for="filter_search" class="element-invisible"><?php echo JText::_('COM_VPPI_SEARCH_IN_ML_NUMBER'); ?></label>
                    <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="hasTooltip" title="<?php echo JHtml::tooltipText('COM_VPPI_SEARCH_IN_ML_NUMBER'); ?>" />
                </div>
                <div class="btn-group pull-left">
                    <button type="submit" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>">
                        <i class="icon-search"></i></button>
                    <button type="button" class="btn hasTooltip" title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();">
                        <i class="icon-remove"></i></button>
                </div>
                <div class="btn-group pull-right hidden-phone">
                    <label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC'); ?></label>
                    <?php echo $this->pagination->getLimitBox(); ?>
                </div>
                <div class="btn-group pull-right hidden-phone">
                    <label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></label>
                    <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
                        <option value=""><?php echo JText::_('JFIELD_ORDERING_DESC'); ?></option>
                        <option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_ASCENDING'); ?></option>
                        <option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>><?php echo JText::_('JGLOBAL_ORDER_DESCENDING'); ?></option>
                    </select>
                </div>
                <div class="btn-group pull-right">
                    <label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY'); ?></label>
                    <select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
                        <option value=""><?php echo JText::_('JGLOBAL_SORT_BY'); ?></option>
                        <?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder); ?>
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th width="1%" class="nowrap center hidden-phone">
                        <?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
                    </th>
                    <th width="1%" class="hidden-phone">
                        <?php echo JHtml::_('grid.checkall'); ?>
                    </th>
                    <th width="left" style="min-width:55px" class="nowrap center">
                        <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
                    </th>
                    <th class="left">
                        <?php echo JHtml::_('grid.sort', 'COM_VPPI_ML_NUMBER', 'a.ml_number', $listDirn, $listOrder); ?>
                    </th>
                    <th width="5%" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'JFEATURED', 'a.featured', $listDirn, $listOrder); ?>
                    </th>
                    <th width="left" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_VPPI_STREET_ADDRESS', 'a.street_address', $listDirn, $listOrder); ?>
                    </th>
                    <th width="left" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_VPPI_CITY', 'a.city', $listDirn, $listOrder); ?>
                    </th>
                    <th width="left" class="nowrap hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'COM_VPPI_STATE_PROV', 'a.state_prov', $listDirn, $listOrder); ?>
                    </th>
                    <th width="1%" class="nowrap center hidden-phone">
                        <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                    </th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <td colspan="10">
                        <?php echo $this->pagination->getListFooter(); ?>
                    </td>
                </tr>
                </tfoot>
                <tbody>
                <?php foreach ($this->items as $i => $item) {
                    $ordering = ($listOrder == 'a.ordering');
                    $canCreate = $user->authorise('core.create', 'com_vppi' . $item->id);
                    $canEdit = $user->authorise('core.edit', 'com_vppi' . $item->id);
                    $canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
                    $canEditOwn = $user->authorise('core.edit.own', 'com_vppi' . $item->id) && $item->created_by == $userId;
                    $canChange = $user->authorise('core.edit.state', 'com_vppi' . $item->id) && $canCheckin;
                    ?>
                    <tr class="row<?php echo $i % 2; ?>">
                        <td class="order nowrap center hidden-phone">
                            <?php
                            $iconClass = '';
                            if (!$canChange) {
                                $iconClass = ' inactive';
                            } elseif (!$saveOrder) {
                                $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
                            }
                            ?>
                            <span class="sortable-handler<?php echo $iconClass ?>">
							<i class="icon-menu"></i>
						</span>
                            <?php if ($canChange && $saveOrder) { ?>
                                <input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
                            <?php
                            }
                            ?>
                        </td>
                        <td class="center hidden-phone">
                            <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                        </td>
                        <?php if (isset($this->items[0]->state)) { ?>
                            <td class="center">
                                <?php echo JHtml::_('jgrid.published', $item->state, $i, 'homes.', $canChange, 'cb'); ?>
                            </td>
                        <?php
                        }
                        ?>
                        <td class="nowrap has-context">
                            <?php if ($item->checked_out) { ?>
                                <?php echo JHtml::_('jgrid.checkedout', $i, $item->editor, $item->checked_out_time, 'homes.', $canCheckin); ?>
                            <?php
                            }
                            ?>
                            <?php if ($canEdit) { ?>
                                <a href="<?php echo JRoute::_('index.php?option=com_vppi&task=home.edit&id=' . (int)$item->id); ?>">
                                    <?php echo $this->escape($item->ml_number); ?></a>
                            <?php
                            } else {
                                echo $this->escape($item->ml_number); ?>
                            <?php
                            }
                            ?>
                        </td>
                        <td class="center hidden-phone">
                            <?php echo JHtml::_('home.featured', $item->featured, $i, $canChange); ?>
                        </td>
                        <td class="center hidden-phone">
                            <?php echo $item->street_address; ?>
                        </td>
                        <td class="center hidden-phone">
                            <?php echo $item->city; ?>
                        </td>
                        <td class="center hidden-phone">
                            <?php echo $item->state_prov; ?>
                        </td>
                        <td class="center">
                            <?php echo (int)$item->id; ?>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
            <input type="hidden" name="task" value="" /> <input type="hidden" name="boxchecked" value="0" />
            <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
            <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
</form>
