<?php

declare(strict_types=1);

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupCollectionInterface;

final class WebpackEncoreResetListener implements EventSubscriberInterface
{
    /**
     * @var \Symfony\WebpackEncoreBundle\Asset\EntrypointLookupCollectionInterface
     */
    private $entryPointLookupCollection;

    public function __construct(EntrypointLookupCollectionInterface $entryPointLookupCollection)
    {
        $this->entryPointLookupCollection = $entryPointLookupCollection;
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => 'onKernelException'];
    }

    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $this->entryPointLookupCollection->getEntrypointLookup('app')->reset();
    }
}
