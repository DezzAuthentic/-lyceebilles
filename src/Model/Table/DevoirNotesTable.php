<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DevoirNotes Model
 *
 * @property \App\Model\Table\DevoirsTable|\Cake\ORM\Association\BelongsTo $Devoirs
 * @property \App\Model\Table\ElevesTable|\Cake\ORM\Association\BelongsTo $Eleves
 *
 * @method \App\Model\Entity\DevoirNote get($primaryKey, $options = [])
 * @method \App\Model\Entity\DevoirNote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DevoirNote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DevoirNote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevoirNote|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DevoirNote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DevoirNote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DevoirNote findOrCreate($search, callable $callback = null, $options = [])
 */
class DevoirNotesTable extends Table
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

        $this->setTable('devoir_notes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Devoirs', [
            'foreignKey' => 'devoir_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Eleves', [
            'foreignKey' => 'eleve_id',
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

        $validator
            ->numeric('note')
            ->allowEmpty('note');

        $validator
            ->scalar('appreciation')
            ->allowEmpty('appreciation');

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
        $rules->add($rules->existsIn(['devoir_id'], 'Devoirs'));
        $rules->add($rules->existsIn(['eleve_id'], 'Eleves'));

        return $rules;
    }
}
