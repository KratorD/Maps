<?php
/**
 * Maps.
 *
 * @copyright Krator (TdM)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Krator <torredemarfil@heroesofmightandmagic.es>.
 * @link https://www.heroesofmightandmagic.es
 * @link http://zikula.org
 * @version Generated by ModuleStudio 1.2.0 (https://modulestudio.de).
 */

namespace TdM\MapsModule\Block\Base;

use Zikula\BlocksModule\AbstractBlockHandler;

/**
 * Moderation block base class.
 */
abstract class AbstractModerationBlock extends AbstractBlockHandler
{
    /**
     * Display the block content.
     *
     * @param array $properties The block properties
     *
     * @return string
     */
    public function display(array $properties = [])
    {
        // only show block content if the user has the required permissions
        if (!$this->hasPermission('TdMMapsModule:ModerationBlock:', "$properties[title]::", ACCESS_OVERVIEW)) {
            return '';
        }
    
        $currentUserApi = $this->get('zikula_users_module.current_user');
        if (!$currentUserApi->isLoggedIn()) {
            return '';
        }
    
        $template = $this->getDisplayTemplate();
    
        $workflowHelper = $this->get('tdm_maps_module.workflow_helper');
        $amounts = $workflowHelper->collectAmountOfModerationItems();
    
        // set a block title
        if (empty($properties['title'])) {
            $properties['title'] = $this->__('Moderation');
        }
    
        return $this->renderView($template, ['moderationObjects' => $amounts]);
    }
    
    /**
     * Returns the template used for output.
     *
     * @return string the template path
     */
    protected function getDisplayTemplate()
    {
        return '@TdMMapsModule/Block/moderation.html.twig';
    }
}
