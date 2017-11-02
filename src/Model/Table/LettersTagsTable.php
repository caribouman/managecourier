<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LettersTags Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Letters
 * @property \Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\LettersTag get($primaryKey, $options = [])
 * @method \App\Model\Entity\LettersTag newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LettersTag[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LettersTag|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LettersTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LettersTag[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LettersTag findOrCreate($search, callable $callback = null)
 */
class LettersTagsTable extends Table
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

        $this->table('letters_tags');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Letters', [
            'foreignKey' => 'letter_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
            'joinType' => 'INNER'
        ]);
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

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['letter_id'], 'Letters'));
        $rules->add($rules->existsIn(['tag_id'], 'Tags'));

        return $rules;
    }
}
