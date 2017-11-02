<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tag'), ['action' => 'edit', $tag->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tag'), ['action' => 'delete', $tag->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tag->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tags'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tag'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Letters'), ['controller' => 'Letters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Letter'), ['controller' => 'Letters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tags view large-9 medium-8 columns content">
    <h3><?= h($tag->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($tag->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($tag->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Letters') ?></h4>
        <?php if (!empty($tag->letters)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Reference') ?></th>
                <th scope="col"><?= __('File') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($tag->letters as $letters): ?>
            <tr>
                <td><?= h($letters->id) ?></td>
                <td><?= h($letters->reference) ?></td>
                <td><?= h($letters->file) ?></td>
                <td><?= h($letters->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Letters', 'action' => 'view', $letters->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Letters', 'action' => 'edit', $letters->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Letters', 'action' => 'delete', $letters->id], ['confirm' => __('Are you sure you want to delete # {0}?', $letters->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
