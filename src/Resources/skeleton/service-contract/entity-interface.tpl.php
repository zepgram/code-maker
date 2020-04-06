<?php
use Zepgram\CodeMaker\FormatString;

?>
<?= "<?php\n" ?>

namespace <?= $name_space_api_data ?>;

/**
 * Interface <?= $class_entity?>Interface.
 */
interface <?= $class_entity ?>Interface
{
<?php foreach ($entity_fields as $field => $option): ?>
    const <?= FormatString::asUpperSnakeCase($field) ?> = '<?= FormatString::asSnakeCase($field)."';\n" ?>
<?php endforeach; ?>

<?php foreach ($entity_fields as $field => $option): ?>
<?php $fieldName = FormatString::asPascaleCase($field); ?>
<?php $fieldParameter = FormatString::asCamelCase($field); ?>
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
     * @return $this<?= "\n" ?>
     */
    public function set<?= $fieldName ?>(<?= $option['type'] ?> $<?= $fieldParameter ?>);
<?php if ($field !== array_key_last($entity_fields)):
echo "\n";
endif?>
<?php endforeach; ?>
}
