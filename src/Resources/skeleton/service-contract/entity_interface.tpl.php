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
    const <?= Str::asUpperSnakeCase($field) ?> = '<?= Str::asSnakeCase($field)."';\n" ?>
<?php endforeach; ?>

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
