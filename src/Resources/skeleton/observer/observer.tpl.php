<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_observer ?>;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class <?= $name_observer ?> implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        // @todo: implement observer
    }
}
