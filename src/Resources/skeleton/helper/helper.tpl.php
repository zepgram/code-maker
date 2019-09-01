<?= "<?php\n" ?>

namespace <?= $name_space ?>;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

/**
 * Class <?= $class_name ?>.
 */
class <?= $class_name ?> extends AbstractHelper
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
