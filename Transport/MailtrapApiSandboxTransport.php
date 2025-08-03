<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mailer\Bridge\Mailtrap\Transport;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Kieran Cross
 */
final class MailtrapApiSandboxTransport extends MailtrapApiTransport
{
    protected const HOST = 'sandbox.api.mailtrap.io';

    public function __construct(
        #[\SensitiveParameter] private string $token,
        private int $inboxId,
        ?HttpClientInterface $client = null,
        ?EventDispatcherInterface $dispatcher = null,
        ?LoggerInterface $logger = null,
    ) {
        parent::__construct($token, $client, $dispatcher, $logger);
    }

    public function __toString(): string
    {
        return \sprintf('mailtrap+sandbox://%s%s/?inboxId=%u', $this->host ?: static::HOST, $this->port ? ':'.$this->port : '', $this->inboxId);
    }

    protected function getEndpoint(): string
    {
        return parent::getEndpoint().'/'.$this->inboxId;
    }
}
