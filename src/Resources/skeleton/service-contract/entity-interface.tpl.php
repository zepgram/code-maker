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
<?php foreach ($entity_fields as $field): ?>
    const <?= FormatString::asUpperSnakeCase($field['value']) ?> = '<?= FormatString::asSnakeCase($field['value'])."';\n" ?>
<?php endforeach; ?>

<?php foreach ($entity_fields as $field): ?>
<?php $fieldName = FormatString::asPascaleCase($field['value']); ?>
<?php $fieldParameter = FormatString::asCamelCase($field['value']); ?>
     /**
      * Get <?= "$fieldName\n" ?>
      *
      * @return <?= $field['type']."\n" ?>
      */
     public function get<?= $fieldName ?>();

     /**
      * Set <?= "$fieldName\n" ?>
      *
      * @param <?= $field['type'] ?> $<?= "$fieldParameter\n" ?>
      * @return $this<?= "\n" ?>
      */
     public function set<?= $fieldName ?>(<?= $field['type'] ?> $<?= $fieldParameter ?>);
<?php if ($field['value'] !== end($entity_fields)['value']):
echo "\n";
endif?>
<?php endforeach; ?>
}
