<?php
$output = $name_camel_case.'Output';
?>
<?php if ($type === 'query'): ?>
type Query {
<?php endif; ?>
<?php if ($type === 'mutation'): ?>
type Mutation {
<?php endif; ?>
    <?= $name_camel_case ?>(id: Int): <?= $output ?> @resolver(class: "<?= $use_escaped_resolver ?>") @doc(description:"<?= $description ?>")
}

type <?= $output ?> {

}
