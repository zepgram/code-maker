<?php
use Zepgram\CodeMaker\FormatString;

?>
<?= "<?php\n" ?>

namespace <?= $name_space_entity ?>;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class <?= $class_entity ?>.
 */
class <?= "$class_entity\n"?>
{
<?php foreach ($config_fields as $option): ?>
    const <?= $option['const'] ?> = '<?= $option['xml']."';\n" ?>
<?php endforeach; ?>

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * <?= $class_entity ?> constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

<?php foreach ($config_fields as $field => $option): ?>
<?php $fieldName = FormatString::asPascaleCase($field); ?>
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
