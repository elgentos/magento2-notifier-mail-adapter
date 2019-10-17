<?php

declare(strict_types=1);

namespace Elgentos\NotifierMagentoMailAdapter\Api;

interface SendMessageInterface
{
    /**
     * Send a magento email template
     * @param string $channelCode
     * @param string $templateId
     * @param array $params
     * @return bool
     */
    public function execute(string $channelCode, string $templateId, array $params = []): bool;
}
