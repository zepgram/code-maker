<?= "<?php\n" ?>

namespace <?= $name_space_view_model ?>;

use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class <?= $class_view_model ?>.
 */
class <?= $class_view_model ?> implements ArgumentInterface
{
<?php if (isset($template)): ?>
    public function getHelloWorld()
    {
        return 'Hello World';
    }
<?php endif ?>
}
