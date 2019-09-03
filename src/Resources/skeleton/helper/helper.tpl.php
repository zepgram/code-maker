<?= "<?php\n" ?>

namespace <?= $name_space_helper ?>;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

/**
 * Class <?= $class_helper ?>.
 */
class <?= $class_helper ?> extends AbstractHelper
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
