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

namespace TdM\MapsModule\Helper\Base;

use IntlDateFormatter;
use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\Common\Translator\TranslatorInterface;
use TdM\MapsModule\Entity\MapEntity;
use TdM\MapsModule\Helper\ListEntriesHelper;

/**
 * Entity display helper base class.
 */
abstract class AbstractEntityDisplayHelper
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var ListEntriesHelper Helper service for managing list entries
     */
    protected $listEntriesHelper;

    /**
     * @var IntlDateFormatter Formatter for dates
     */
    protected $dateFormatter;

    /**
     * EntityDisplayHelper constructor.
     *
     * @param TranslatorInterface $translator        Translator service instance
     * @param RequestStack        $requestStack      RequestStack service instance
     * @param ListEntriesHelper   $listEntriesHelper Helper service for managing list entries
     */
    public function __construct(
        TranslatorInterface $translator,
        RequestStack $requestStack,
        ListEntriesHelper $listEntriesHelper
    ) {
        $this->translator = $translator;
        $this->listEntriesHelper = $listEntriesHelper;
        $locale = null !== $requestStack->getCurrentRequest() ? $requestStack->getCurrentRequest()->getLocale() : null;
        $this->dateFormatter = new IntlDateFormatter($locale, null, null);
    }

    /**
     * Returns the formatted title for a given entity.
     *
     * @param object $entity The given entity instance
     *
     * @return string The formatted title
     */
    public function getFormattedTitle($entity)
    {
        if ($entity instanceof MapEntity) {
            return $this->formatMap($entity);
        }
    
        return '';
    }
    
    /**
     * Returns the formatted title for a given entity.
     *
     * @param MapEntity $entity The given entity instance
     *
     * @return string The formatted title
     */
    protected function formatMap(MapEntity $entity)
    {
        return $this->translator->__f('%name% %game%', [
            '%name%' => $entity->getName(),
            '%game%' => $this->listEntriesHelper->resolve($entity->getGame(), 'map', 'game')
        ]);
    }
    
    /**
     * Returns name of the field used as title / name for entities of this repository.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return string Name of field to be used as title
     */
    public function getTitleFieldName($objectType)
    {
        if ($objectType == 'map') {
            return 'name';
        }
    
        return '';
    }
    
    /**
     * Returns name of the field used for describing entities of this repository.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return string Name of field to be used as description
     */
    public function getDescriptionFieldName($objectType)
    {
        if ($objectType == 'map') {
            return 'description';
        }
    
        return '';
    }
    
    /**
     * Returns name of first upload field which is capable for handling images.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return string Name of field to be used for preview images
     */
    public function getPreviewFieldName($objectType)
    {
        if ($objectType == 'map') {
            return 'foreground';
        }
    
        return '';
    }
    
    /**
     * Returns name of the date(time) field to be used for representing the start
     * of this object. Used for providing meta data to the tag module.
     *
     * @param string $objectType Name of treated entity type
     *
     * @return string Name of field to be used as date
     */
    public function getStartDateFieldName($objectType)
    {
        if ($objectType == 'map') {
            return 'createdDate';
        }
    
        return '';
    }
}
