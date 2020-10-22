<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Completeness\Infrastructure\Handler\Event;

use Ergonode\Designer\Domain\Event\TemplateElementRemovedEvent;
use Ergonode\EventSourcing\Infrastructure\Bus\CommandBusInterface;
use Ergonode\Product\Domain\Query\ProductQueryInterface;
use Ergonode\Completeness\Domain\Command\ProductCompletenessCalculateCommand;

class TemplateElementRemovedEventHandler
{
    /**
     * @var CommandBusInterface
     */
    private CommandBusInterface $commandBus;

    /**
     * @var ProductQueryInterface
     */
    private ProductQueryInterface $query;

    /**
     * @param CommandBusInterface   $commandBus
     * @param ProductQueryInterface $query
     */
    public function __construct(CommandBusInterface $commandBus, ProductQueryInterface $query)
    {
        $this->commandBus = $commandBus;
        $this->query = $query;
    }

    /**
     * @param TemplateElementRemovedEvent $event
     */
    public function __invoke(TemplateElementRemovedEvent $event): void
    {
        $products = $this->query->findProductIdsByTemplate($event->getAggregateId());
        foreach ($products as $product) {
            $command = new ProductCompletenessCalculateCommand($product);
            $this->commandBus->dispatch($command, true);
        }
    }
}