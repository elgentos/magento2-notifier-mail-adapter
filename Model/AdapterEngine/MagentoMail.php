<?php

declare(strict_types=1);

namespace Elgentos\NotifierMagentoMailAdapter\Model\AdapterEngine;

use Exception;
use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\Store;
use MSP\Notifier\Model\AdapterEngine\AdapterEngineInterface;
use MSP\Notifier\Model\SerializerInterface;

class MagentoMail implements AdapterEngineInterface
{
    const ADAPTER_CODE = 'magento_mail';

    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var State
     */
    protected $appState;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    public function __construct(
        SerializerInterface $serializer,
        State $appState,
        TransportBuilder $transportBuilder
    ) {
        $this->serializer = $serializer;
        $this->transportBuilder = $transportBuilder;
        $this->appState = $appState;
    }

    public function execute(string $message, array $params = []): bool
    {
        try {
            $config = $this->serializer->unserialize($message);
        } catch (Exception $exception) {
            $config = [];
        }

        $config = $this->mergeDefaultConfig($config);

        $this->appState->emulateAreaCode(
            $config['area'],
            [$this, 'sendEmail'],
            [$config, $params]
        );

        return true;
    }

    public function sendEmail($config, $params)
    {
        $transport = $this->transportBuilder
            ->setTemplateIdentifier($config['template_id'])
            ->setTemplateOptions([
                'area' => $config['area'],
                'store' => $config['store_id'],
            ])
            ->setFromByScope([
                'email' => $config['from'] ?? $params['from'],
                'name' => $config['from_name'] ?? $params['from_name']
            ])
            ->setTemplateVars($config['template_vars'] ?? [])
            ->addTo($config['to'])
            ->getTransport();

        $transport->sendMessage();
    }

    public function mergeDefaultConfig($config)
    {
        return [
            'area' => Area::AREA_FRONTEND,
            'store_id' => Store::DEFAULT_STORE_ID
        ] + $config;
    }
}