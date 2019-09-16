<?php

use Zepgram\CodeMaker\FormatString;

?>
<?= "<?php\n" ?>

namespace <?= $name_space_hydrator ?>;

use <?= $use_class_entity_interface ?>;
use Magento\Framework\EntityManager\HydratorInterface;
use Magento\Framework\DataObject;

/**
 * Class <?= $class_entity ?>Hydrator.
 */
class <?= $class_entity ?>Hydrator implements HydratorInterface
{
    /**
     * @var array
     */
    private $mapping = [
<?php foreach ($entity_fields as $field): ?>
        <?= $class_entity ?>Interface::<?= FormatString::asUpperSnakeCase($field['value']) ?> => '<?= FormatString::asPascaleCase($field['value']) ?>',
<?php endforeach; ?>
    ];

    /**
     * Extract data from object
     *
     * @param object $entity
     *
     * @return array
     */
    public function extract($entity)
    {
        $data = [];
        foreach ($this->mapping as $key => $method) {
            if (method_exists($entity, 'get' . $method)) {
                $value = $entity->{'get' . $this->mapping[$key]}();
                if (null !== $value) {
                    $data[$key] = $entity->{'get' . $this->mapping[$key]}();
                }
            }
        }

        return $data;
    }

    /**
     * Populate entity with data
     *
     * @param DataObject $entity
     * @param array      $data
     *
     * @return object
     */
    public function hydrate($entity, array $data)
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->mapping)) {
                $entity->{'set' . $this->mapping[$key]}($data[$key]);
            }
        }

        return $entity;
    }
}