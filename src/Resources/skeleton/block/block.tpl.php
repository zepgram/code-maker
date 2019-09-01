<?= "<?php\n" ?>

namespace <?= $name_space ?>\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

/**
 * Class <?= $class_name ?>.
 */
class <?= $class_name ?> extends Template
{
    public function __construct(Context $context, array $data = [])
    {
        parent::__construct($context, $data);
    }
}
