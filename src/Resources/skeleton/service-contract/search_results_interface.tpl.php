<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_search_results_interface ?>;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface <?= $name_search_results_interface ?>.
 */
interface <?= $name_search_results_interface ?> extends SearchResultsInterface
{
    /**
     * Get <?= $name_entity_interface ?> items
     *
     * @return <?= $name_entity_interface ?>[]
     */
    public function getItems();

    /**
     * Set <?= $name_entity_interface ?> items
     *
     * @param <?= $name_entity_interface ?>[] $items
     * @return $this
     */
    public function setItems(array $items);
}
