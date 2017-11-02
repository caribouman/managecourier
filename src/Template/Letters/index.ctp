<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Letter'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tags'), ['controller' => 'Tags', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tag'), ['controller' => 'Tags', 'action' => 'add']) ?></li>


        <div class="tags_depot" ondragstart="drag(event)" ondrop="drop(event)" ondragover="allowDrop(event)">
            <ul class="tags-list">
                <?php
                //print_r($tags);
                //print_r($tag_id);
                foreach ($tags as $key=>$tag):
                    if (!isset($tag_id)) {
                        ?>

                        <li id="<?= $tag ?>" value="<?= $key ?>" draggable="true" ondragstart="drag(event)"
                            ondragover="allowDrop(event)" ondrop="drop(event)">
                            <div class="tags"><?= $tag ?></div>
                        </li>
                        <?php

                    } elseif (!in_array($key, $tag_id)) {



                            ?>

                            <li id="<?= $tag ?>" value="<?= $key ?>" draggable="true" ondragstart="drag(event)"
                                ondragover="allowDrop(event)" ondrop="drop(event)">
                                <div class="tags"><?= $tag ?></div>
                            </li>
                            <?php


                    }
                endforeach; ?>
            </ul>
        </div>

    </ul>
</nav>
<div class="letters index large-9 medium-8 columns content">
    <h3><?= __('Letters') ?></h3>
  <?php  echo $this->Form->create();
    // You'll need to populate $authors in the template from your controller
  //echo $this->Form->input('letter_id');
    //echo $this->Form->input('reference');
    // Match the search param in your table configuration
    echo $this->Form->input('q');
    echo $this->Form->input('tag_id', ['options' => $tags,'multiple'=>true, 'id'=>'valeurstag']);
  ?>

  <label for="receiver">Tags</label>
        <div id="receiver" class="tags_depot" ondragstart="drag(event)" ondrop="drop(event)" ondragover="allowDrop(event)">
            <ul class="tags-list">
                <?php
                //print_r($tags);
                //print_r($tag_id);
                foreach ($tags as $key=>$tag):
                    if (isset($tag_id)){
                        if (in_array($key, $tag_id)) {
                            ?>

                         <li id="<?= $tag ?>" value="<?= $key ?>" draggable="true" ondragstart="drag(event)"
                            ondragover="allowDrop(event)" ondrop="drop(event)">
                            <div class="tags"><?= $tag ?></div>
                         </li>


                        <?php
                        }
                    }


                endforeach; ?>
            </ul>


        </div>
    <?php
    echo $this->Form->input('date', ['class' => 'datepicker-input']);
    echo $this->Form->button('Filter', ['type' => 'submit', 'id'=>'filter']);
    echo $this->Html->link('Reset', ['action' => 'index']);
    echo $this->Form->end();
  ?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('reference') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($letters as $letter): ?>
            <tr>
                <td><?= $this->Number->format($letter->id) ?></td>
                <td><?= h($letter->reference) ?></td>
                <td><?= h($letter->created) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $letter->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $letter->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $letter->id], ['confirm' => __('Are you sure you want to delete # {0}?', $letter->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>

<script type="text/javascript">
    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
        ev.preventDefault();
        var data = ev.dataTransfer.getData("text");
        ev.target.appendChild(document.getElementById(data));


        var receiver=document.getElementById('receiver');

        var listes=receiver.getElementsByTagName('li');

        var input = document.getElementById('valeurstag');
        var options= input.getElementsByTagName('option');


        //reinit select
        for (var i = 0, c = options.length ; i < c ; i++) {


            options[i].selected=false;

        }

        for (var i = 0, c = listes.length ; i < c ; i++) {


            options[listes[i].value-1].selected=true;

        }


        document.getElementById('filter').click();

    }


$(function() {
$('.datepicker-input').datepicker( {
changeMonth: true,
changeYear: true,
showButtonPanel: true,
dateFormat: 'mm/yy',
onClose: function(dateText, inst) {
$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
}
});
});
</script>

