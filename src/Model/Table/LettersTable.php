<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Model\Filter\Callback;
use Search\Manager;
use Cake\Utility\Text;

/**
 * Letters Model
 *
 * @property \Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \App\Model\Entity\Letter get($primaryKey, $options = [])
 * @method \App\Model\Entity\Letter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Letter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Letter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Letter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Letter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Letter findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LettersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */

    public function initialize(array $config)
    {
        parent::initialize($config);


       

        $this->table('letters');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Tree');

        $this->addBehavior('Josegonzalez/Upload.Upload', [

                            'file'=> [
                                'nameCallback' =>  function(array $data, array $settings) {
                                    $ext = substr(strrchr($data['name'], '.'), 1);
                                    return Text::uuid() . '.' . $ext;
                                },
                                            'fields' => [
                                               'dir' => 'letterFileDir'
                                            ]

                            ]])
               ;


           $this->hasOne('answer', [
               'className' => 'Letters',
           ]);


           $this->belongsTo('parentLetter',[
               'foreignKey' => 'parent_id',
               'className'=>'Letters']);

        $this->belongsToMany('Tags', [
            'foreignKey' => 'letter_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'letters_tags'
        ]);






    }



    public function searchConfiguration()
    {
        $search = new Manager($this);

        $search->value('letter_id')
            ->add('tags._ids', 'Search.Callback',
            [
                'callback' => function (Query $query, array $args, Callback $type) {
                    $tag_ids=explode(',',$args['tags._ids']);
                    $nombretags=count( $tag_ids);
                   // debug($tag_ids);
                    switch ($nombretags) {
                        case 1:

                            //   SELECT *
                            //   FROM letters AS l
                            //INNER JOIN letters_tags AS at1 ON (l.id = at1.letter_id)
                            //INNER JOIN tags AS t1 ON (t1.id = at1.tag_id AND t1.id = 3)
                            //INNER JOIN letters_tags AS at2 ON (l.id = at2.letter_id)
                            //INNER JOIN tags AS t2 ON (t2.id = at2.tag_id AND t2.id = 1)
                            return $query->matching('Tags', function ($q) use ($args) {
                                return $q->where(['Tags.id' => $args['tags._ids']]);
                            });
                            break;
                        case 2:
                            return $query->innerJoin(['at1'=>'letters_tags'],[
                                'Letters.id = at1.letter_id'])->innerJoin(['t1'=>'tags'],["t1.id = at1.tag_id",
                                "t1.id =". $tag_ids[0]])->innerJoin(['at2'=>'letters_tags'],[
                                'Letters.id = at2.letter_id'])->innerJoin(['t2'=>'tags'],["t2.id = at2.tag_id",
                                "t2.id =". $tag_ids[1]]);
                            break;
                        case 3:
                            return $query->innerJoin(['at1'=>'letters_tags'],[
                                'Letters.id = at1.letter_id'])->innerJoin(['t1'=>'tags'],["t1.id = at1.tag_id",
                                "t1.id =". $tag_ids[0]])->innerJoin(['at2'=>'letters_tags'],[
                                'Letters.id = at2.letter_id'])->innerJoin(['t2'=>'tags'],["t2.id = at2.tag_id",
                                "t2.id =". $tag_ids[1]])->innerJoin(['at3'=>'letters_tags'],[
                                'Letters.id = at3.letter_id'])->innerJoin(['t3'=>'tags'],["t3.id = at3.tag_id",
                                "t3.id =". $tag_ids[2]]);
                            break;
                        case 4:
                            return $query->innerJoin(['at1'=>'letters_tags'],[
                                'Letters.id = at1.letter_id'])->innerJoin(['t1'=>'tags'],["t1.id = at1.tag_id",
                                "t1.id =". $tag_ids[0]])->innerJoin(['at2'=>'letters_tags'],[
                                'Letters.id = at2.letter_id'])->innerJoin(['t2'=>'tags'],["t2.id = at2.tag_id",
                                "t2.id =". $tag_ids[1]])->innerJoin(['at3'=>'letters_tags'],[
                                'Letters.id = at3.letter_id'])->innerJoin(['t3'=>'tags'],["t3.id = at3.tag_id",
                                "t3.id =". $tag_ids[2]])->innerJoin(['at4'=>'letters_tags'],[
                                'Letters.id = at4.letter_id'])->innerJoin(['t4'=>'tags'],["t4.id = at4.tag_id",
                                "t4.id =". $tag_ids[3]]);
                            break;
                    }




                }

            ])        ->add('q', 'Search.Like', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => ['reference']
            ])->add('date_letter', 'Search.Like', [
                'before' => true,
                'after' => true,
                'mode' => 'or',
                'comparison' => 'LIKE',
                'wildcardAny' => '*',
                'wildcardOne' => '?',
                'field' => ['reference']
            ]);

                    return $search;
    }


    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('reference', 'create')
            ->notEmpty('reference');



        $validator
            ->add('tags', 'validTag', [
                'rule' => 'isValidTag',
                'message' => __('Vous devez fournir un tag entrada o saida'),
                'provider' => 'table',
            ]);

        $validator
            ->notEmpty('letterFile')
            ->add('letterFile', [
                'validExtension' => [
                    'rule' => ['extension',['pdf']], // default  ['gif', 'jpeg', 'png', 'jpg']
                    'message' => __('These files extension are allowed: .pdf')
                ]
            ]);
            
		

        return $validator;
    }


    public function isValidTag($value, array $context)
    {
        //debug($value);
        //debug( (in_array('1',$value['_ids'])|| in_array('2',$value['_ids'])));
        //return (in_array('1',$value['_ids'])|| in_array('2',$value['_ids']));
        return true;
    }

	 public function buildRules(RulesChecker $rules){

         $rules->add($rules->isUnique(['reference']));

        return $rules;
    }


	
}
