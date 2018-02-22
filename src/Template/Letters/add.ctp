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
        <?= $this->Form->input('tags._ids', ['options' => $tags, 'multiple'=>true, 'id'=>'valeurstag']);?>
        <label for="receiver">Tags</label>
        <div id="receiver" class="tags_depot" ondragstart="drag(event)" ondrop="drop(event)" ondragover="allowDrop(event)"></div>
        <?= $this->Form->input('date_letter',['dateFormat' => 'DDMMYYYY',
                                              'templates' => ['dateWidget' => '<div class="clearfix">{{day}}<span class="spacer-date">/</span>{{month}}<span class="spacer-date">/</span>{{year}}</div>',
        ]]);?>
        
        <?= $this->Form->select('parent_id', $letters,['empty' => true]);?>
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


   // $('#letter-id').selectize({
       // valueField: 'url',
       // labelField: 'name',
       // searchField: 'name',
     //   create: false,
   /*     render: {
            option: function(item, escape) {
                return '<div>' +
                    '<span class="title">' +
                    '<span class="name"><i class="icon ' + (item.fork ? 'fork' : 'source') + '"></i>' + escape(item.name) + '</span>' +
                    '<span class="by">' + escape(item.username) + '</span>' +
                    '</span>' +
                    '<span class="description">' + escape(item.description) + '</span>' +
                    '<ul class="meta">' +
                    (item.language ? '<li class="language">' + escape(item.language) + '</li>' : '') +
                    '<li class="watchers"><span>' + escape(item.watchers) + '</span> watchers</li>' +
                    '<li class="forks"><span>' + escape(item.forks) + '</span> forks</li>' +
                    '</ul>' +
                    '</div>';
            }
        },*/
       /* score: function(search) {
            var score = this.getScoreFunction(search);
            return function(item) {
                return score(item) * (1 + Math.min(item.watchers / 100, 1));
            };
        },*/
        /*load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: 'https://api.github.com/legacy/repos/search/' + encodeURIComponent(query),
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                    callback(res.repositories.slice(0, 10));
                }
            });
        }*/
   // });



</script>
