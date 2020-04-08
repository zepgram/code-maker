<?= "<?php\n" ?>

namespace <?= $namespace_view_model ?>;

use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class <?= $name_view_model ?>.
 */
class <?= $name_view_model ?> implements ArgumentInterface
{
    public function getHelloWorld()
    {
        return 'Hello World';
    }
}
