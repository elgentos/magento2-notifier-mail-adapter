<?php

declare(strict_types=1);

namespace Elgentos\NotifierMagentoMailAdapter\Console\Command;

use Elgentos\NotifierMagentoMailAdapter\Api\SendMessageInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MessageTestCommand extends Command
{
    protected $sendMessage;

    public function __construct(SendMessageInterface $sendMessage)
    {
        parent::__construct();

        $this->sendMessage = $sendMessage;
    }

    protected function configure()
    {
        $this->setName('elgentos:message');
        $this->setDescription('Send message with magento mail adapter');
        $this->addArgument('email', InputArgument::REQUIRED, 'Email');

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $params = [
            'to' => $input->getArgument('email'),
            'template_vars' => [
                'templatevar' => 'Your test var'
            ]
        ];

        $this->sendMessage->execute('magento_mail', 'magento_mail', $params);
    }
}