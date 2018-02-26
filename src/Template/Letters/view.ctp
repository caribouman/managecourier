<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Letter'), ['action' => 'edit', $letter->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Letter'), ['action' => 'delete', $letter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $letter->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Letters'), ['action' => 'index']) ?> </li>

    </ul>
</nav>
<div class="letters view large-9 medium-8 columns content">
    <h3><?= 'REF:'.h($letter->reference) ?></h3>
    <table class="vertical-table">

        <tr>
            <th scope="row"><?= __('File') ?></th>
            <td>
                <?php
                $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $letter['file']);
                $nomfichierimage= '/'. $letter->letterFileDir . $withoutExt.'.png';
                ?>
                <?=

                $this->Html->link($this->Html->image(str_replace("\\","/",$nomfichierimage)),'/'. $letter->letterFileDir . '/' . $letter->file,
                    ['escape' => false]);
                ?>
            </td>

        </tr>

        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($letter->created) ?></td>
        </tr>

    </table>
    <div class="related">
        <h4><?= __('Related Tags') ?></h4>
        <?php if (!empty($letter->tags)): ?>
        <table cellpadding="0" cellspacing="0">
            <?php foreach ($letter->tags as $tags): ?>
            <tr>

                <td><?= h($tags->name) ?></td>

            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
    <div class="related">
        <h4><?= __('Answer of') ?></h4>

        <?php if (!empty($answers)):
            echo '<ul>';
            $i=0;
            foreach($answers as $answer){ ?>
            <ul>
             <li><?= $this->Html->link(
                 $answer['reference'].'--'.$answer['created'],
                 ['controller' => 'Letters', 'action' => 'view', $answer['id']]
                 ); ?></li>




        <?php   $i++;     }
        for($j=0;$j==$i;$j++){
            echo '</ul>';
        }
        endif; ?>

    </div>
</div>
