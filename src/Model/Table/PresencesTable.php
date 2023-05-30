<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Presences Model
 *
 * @property \App\Model\Table\SeancesTable|\Cake\ORM\Association\BelongsTo $Seances
 * @property \App\Model\Table\ElevesTable|\Cake\ORM\Association\BelongsTo $Eleves
 *
 * @method \App\Model\Entity\Presence get($primaryKey, $options = [])
 * @method \App\Model\Entity\Presence newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Presence[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Presence|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Presence|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Presence patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Presence[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Presence findOrCreate($search, callable $callback = null, $options = [])
 */
class PresencesTable extends Table
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

        $this->setTable('presences');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Seances', [
            'foreignKey' => 'seance_id',
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
            ->scalar('type')
            ->maxLength('type', 10)
            ->allowEmpty('type');

        $validator
            ->scalar('motif')
            ->allowEmpty('motif');

        $validator
            ->scalar('justifie')
            ->maxLength('justifie', 3)
            ->allowEmpty('justifie');

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
        $rules->add($rules->existsIn(['seance_id'], 'Seances'));
        $rules->add($rules->existsIn(['eleve_id'], 'Eleves'));

        return $rules;
    }
}
