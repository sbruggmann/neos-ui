<?php
namespace Neos\Neos\Ui\TypeConverter;

/*
 * This file is part of the Neos.Neos.Ui package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\ObjectManagement\ObjectManagerInterface;
use Neos\Flow\Property\PropertyMappingConfigurationInterface;
use Neos\Flow\Property\TypeConverter\AbstractTypeConverter;
use Neos\Media\TypeConverter\ImageInterfaceArrayPresenter;
use Neos\Media\TypeConverter\ImageInterfaceJsonSerializer;
use Neos\Neos\Ui\Fusion\Helper\ActivationHelper;

/**
 * Chooses the right converter to provide image data to the user interface
 */
class UiDependentImageSerializer extends AbstractTypeConverter
{
    /**
     * @Flow\Inject
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Converts the given source ImageInterface depending on which UI is active.
     *
     * @param mixed $source
     * @param string $targetType
     * @param array $convertedChildProperties
     * @param PropertyMappingConfigurationInterface|null $configuration
     * @return mixed|\Neos\Error\Messages\Error|\Neos\Flow\Validation\Error|string
     */
    public function convertFrom($source, $targetType, array $convertedChildProperties = [], PropertyMappingConfigurationInterface $configuration = null)
    {
        $activationHelper = $this->objectManager->get(ActivationHelper::class);

        $innerConverter = $this->objectManager->get(ImageInterfaceArrayPresenter::class);
        if (!$activationHelper->enableNewBackend()) {
            // Old UI is active so we need to deliver the JSON as string.
            $innerConverter = $this->objectManager->get(ImageInterfaceJsonSerializer::class);
        }

        return $innerConverter->convertFrom($source, $targetType, $convertedChildProperties, $configuration);
    }
}
