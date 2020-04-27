<?= "<?php\n" ?>
declare(strict_types=1);

namespace <?= $namespace_helper ?>;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

/**
 * Class <?= $name_helper ?>.
 */
class <?= $name_helper ?> extends AbstractHelper
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }
}
