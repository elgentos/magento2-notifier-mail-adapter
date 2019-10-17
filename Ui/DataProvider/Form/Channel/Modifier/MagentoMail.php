<?php

declare(strict_types=1);

namespace Elgentos\NotifierMagentoMailAdapter\Ui\DataProvider\Form\Channel\Modifier;

use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;
use MSP\Notifier\Model\Channel\ModifierInterface;

class MagentoMail extends AbstractModifier implements ModifierInterface
{
    /**
     * @inheritdoc
     */
    public function modifyMeta(array $meta): array
    {
        $meta['configuration'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Fieldset::NAME,
                        'label' => __('Magento Mail Configuration'),
                        'collapsible' => false,
                    ],
                ],
            ],
            'children' => [
                'from' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Field::NAME,
                                'label' => __('From'),
                                'dataType' => 'text',
                                'formElement' => 'input',
                                'sortOrder' => 10,
                                'dataScope' => 'general.configuration.from',
                                'validation' => [
                                    'required-entry' => true,
                                    'validate-email' => true,
                                ],
                            ],
                        ],
                    ],
                ],
                'from_name' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => Field::NAME,
                                'label' => __('From Name'),
                                'dataType' => 'text',
                                'formElement' => 'input',
                                'sortOrder' => 20,
                                'dataScope' => 'general.configuration.from_name',
                                'validation' => [
                                    'required-entry' => true,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $meta;
    }

    /**
     * @inheritdoc
     */
    public function modifyData(array $data): array
    {
        return $data;
    }

    /**
     * @inheritdoc
     */
    public function getAdapterCode(): string
    {
        return \Elgentos\NotifierMagentoMailAdapter\Model\AdapterEngine\MagentoMail::ADAPTER_CODE;
    }
}