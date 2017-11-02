<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Letters'), ['action' => 'index']) ?></li>
    </ul>
    <?= __('TAGS DISPONIBLE') ?>

    <div class="tags_depot" ondragstart="drag(event)" ondrop="drop(event)" ondragover="allowDrop(event)">
    <ul class="tags-list">
        <?php foreach ($tags as $key=>$tag): ?>

          <li id="<?=$tag?>" value="<?=$key?>" draggable="true" ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)">
              <div class="tags"  ><?= $tag?></div>
          </li>
        <?php endforeach; ?>
    </ul>
    </div>

</nav>



<div class="letters form large-9 medium-8 columns content">
    <?= $this->Form->create($letter, ['type' => 'file','name'=>'letterform']) ?>
    <fieldset>
        <legend><?= __('Add Letter') ?></legend>
        <?= $this->Form->input('id',['type' => 'hidden']);?>
        <?= $this->Form->input('reference');?>
        <?= $this->Form->input('tags._ids', ['options' => $tags, 'multiple'=>true, 'id'=>'valeurstag','type' => 'hidden']);?>
        <label for="receiver">Tags</label>
        <div id="receiver" class="tags_depot" ondragstart="drag(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <?= $this->Form->input('date_letter',['dateFormat' => 'DDMMYYYY',
                                              'templates' => ['dateWidget' => '<div class="clearfix">{{day}}<span class="spacer-date">/</span>{{month}}<span class="spacer-date">/</span>{{year}}</div>',
        ]]);?>
        
        <?= $this->Form->input('letter_id',['options' => $letters,'empty' => true]);?>
		<?= $this->Form->input('file',['type' => 'file']);?>
        <?= $this->Form->input('letterFileDir', ['type' => 'hidden']); ?>
    </fieldset>
	
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
	
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







    }
</script>
