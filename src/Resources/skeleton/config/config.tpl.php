<?php
use Zepgram\CodeMaker\Str;

?>
<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace_config ?>;

use Magento\Framework\App\Config\ScopeConfigInterface;

class <?= "$name_config\n"?>
{
<?php foreach ($option_fields as $option): ?>
    public const <?= $option['const'] ?> = '<?= $option['xml']."';\n" ?>
<?php endforeach; ?>

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * <?= $name_config ?> constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

<?php foreach ($option_fields as $field => $option): ?>
<?php $fieldName = Str::asPascaleCase($field); ?>
    /**
     * Get <?= "$fieldName\n" ?>
     *
     * @return mixed
     */
    public function get<?= $fieldName ?>()
    {
        return $this->scopeConfig->getValue(self::<?= $option['const'] ?>);
    }
<?php endforeach; ?>
}
