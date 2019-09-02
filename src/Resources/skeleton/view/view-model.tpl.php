<?= "<?php\n" ?>

namespace <?= $name_space_view_model ?>;

use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class <?= $view_model ?>.
 */
class <?= $view_model ?> implements ArgumentInterface
{
    public function getHelloWorld()
    {
        return 'Hello World';
    }
}
