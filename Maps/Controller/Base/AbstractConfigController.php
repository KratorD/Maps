<?php
/**
 * Maps.
 *
 * @copyright Krator (TdM)
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @author Krator <torredemarfil@heroesofmightandmagic.es>.
 * @link https://www.heroesofmightandmagic.es
 * @link http://zikula.org
 * @version Generated by ModuleStudio 1.1.0 (https://modulestudio.de).
 */

namespace TdM\MapsModule\Controller\Base;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Zikula\Core\Controller\AbstractController;
use TdM\MapsModule\Form\Type\ConfigType;

/**
 * Config controller base class.
 */
abstract class AbstractConfigController extends AbstractController
{
    /**
     * This method takes care of the application configuration.
     *
     * @param Request $request Current request instance
     *
     * @return Response Output
     *
     * @throws AccessDeniedException Thrown if the user doesn't have required permissions
     */
    public function configAction(Request $request)
    {
        if (!$this->hasPermission($this->name . '::', '::', ACCESS_ADMIN)) {
            throw new AccessDeniedException();
        }
        
        $form = $this->createForm(ConfigType::class);
        
        if ($form->handleRequest($request)->isValid()) {
            if ($form->get('save')->isClicked()) {
                $formData = $form->getData();
                // normalise group selector values
                foreach (['moderationGroupForMaps'] as $groupFieldName) {
                    $formData[$groupFieldName] = is_object($formData[$groupFieldName]) ? $formData[$groupFieldName]->getGid() : $formData[$groupFieldName];
                }
        
                $this->setVars($formData);
        
                $this->addFlash('status', $this->__('Done! Module configuration updated.'));
                $userName = $this->get('zikula_users_module.current_user')->get('uname');
                $this->get('logger')->notice('{app}: User {user} updated the configuration.', ['app' => 'TdMMapsModule', 'user' => $userName]);
            } elseif ($form->get('cancel')->isClicked()) {
                $this->addFlash('status', $this->__('Operation cancelled.'));
            }
        
            // redirect to config page again (to show with GET request)
            return $this->redirectToRoute('tdmmapsmodule_config_config');
        }
        
        $templateParameters = [
            'form' => $form->createView()
        ];
        
        // render the config form
        return $this->render('@TdMMapsModule/Config/config.html.twig', $templateParameters);
    }
}