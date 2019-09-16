<?= "<?php\n" ?>

namespace <?= $name_space_api_data ?>;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface <?= $class_entity ?>SearchResultsInterface.
 */
interface <?= $class_entity ?>SearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get <?= $class_entity ?> items
     *
     * @return <?= $class_entity ?>Interface[]
     */
    public function getItems();

    /**
     * Set <?= $class_entity ?> items
     *
     * @param <?= $class_entity ?>Interface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
