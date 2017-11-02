<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $letter->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $letter->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Letters'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="letters form large-9 medium-8 columns content">
    <?= $this->Form->create($letter) ?>
    <fieldset>
        <legend><?= __('Edit Letter') ?></legend>
        <?php
            echo $this->Form->input('reference');
            echo $this->Form->input('file');
            echo $this->Form->input('tags._ids', ['options' => $tags]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
