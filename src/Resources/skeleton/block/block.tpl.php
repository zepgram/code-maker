<?= "<?php\n" ?>

namespace <?= $name_space_block ?>;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class <?= $class_block ?>.
 */
class <?= $class_block ?> extends Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }
}
