<?php
use Zepgram\CodeMaker\Str;

?>
<?= "<?php\n" ?>

namespace <?= $namespace_entity_interface ?>;

/**
 * Interface <?= $name_entity_interface ?>.
 */
interface <?= "$name_entity_interface\r\n" ?>
{
<?php foreach ($option_fields as $field => $option): ?>
    /** @var <?= $option['type'] ?> */
    const <?= Str::asUpperSnakeCase($field) ?> = '<?= Str::asSnakeCase($field)."';\r\n" ?>
<?php if ($field !== array_key_last($option_fields)):
echo "\n";
endif; ?>
<?php endforeach; ?>

<?php if (isset($primary_key)): ?>
    /**
     * Get Entity Id
     *
     * @return int<?= "\n" ?>
     */
    public function getId();

    /**
     * Set Entity Id
     *
     * @param int $id
     *
     * @return $this<?= "\n" ?>
     */
    public function setId(int $id);

<?php endif; ?>
<?php foreach ($option_fields as $field => $option): ?>
<?php $fieldName = Str::asPascaleCase($field); ?>
<?php $fieldParameter = Str::asCamelCase($field); ?>
    /**
     * Get <?= "$fieldName\n" ?>
     *
     * @return <?= $option['type']."\n" ?>
     */
    public function get<?= $fieldName ?>();

    /**
     * Set <?= "$fieldName\n" ?>
     *
     * @param <?= $option['type'] ?> $<?= "$fieldParameter\n" ?>
     *
     * @return $this<?= "\n" ?>
     */
    public function set<?= $fieldName ?>(<?= $option['type'] ?> $<?= $fieldParameter ?>);
<?php if ($field !== array_key_last($option_fields)):
echo "\n";
endif?>
<?php endforeach; ?>
}
