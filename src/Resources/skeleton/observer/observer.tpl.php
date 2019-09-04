<?= "<?php\n" ?>

namespace <?= $name_space_observer ?>;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Class <?= $class_observer ?>.
 */
class <?= $class_observer ?> implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {

    }
}
