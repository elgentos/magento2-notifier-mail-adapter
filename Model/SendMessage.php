<?php

declare(strict_types=1);

namespace Elgentos\NotifierMagentoMailAdapter\Model;

use Elgentos\NotifierMagentoMailAdapter\Api\SendMessageInterface;
use MSP\Notifier\Model\SerializerInterface;

class SendMessage implements SendMessageInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var \MSP\NotifierApi\Api\SendMessageInterface
     */
    protected $sendMessage;

    public function __construct(
        SerializerInterface $serializer,
        \MSP\NotifierApi\Api\SendMessageInterface $sendMessage
    ) {
        $this->serializer = $serializer;
        $this->sendMessage = $sendMessage;
    }
    
    public function execute(string $channelCode, string $templateId, array $params = []): bool
    {
        $message = $this->serializer->serialize(
            $params + ['template_id' => $templateId]
        );

        return $this->sendMessage->execute($channelCode, $message);
    }
}
