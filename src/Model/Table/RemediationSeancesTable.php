<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RemediationSeances Model
 *
 * @property \App\Model\Table\RemediationsTable|\Cake\ORM\Association\BelongsTo $Remediations
 *
 * @method \App\Model\Entity\RemediationSeance get($primaryKey, $options = [])
 * @method \App\Model\Entity\RemediationSeance newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RemediationSeance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RemediationSeance|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RemediationSeance|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RemediationSeance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RemediationSeance[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RemediationSeance findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RemediationSeancesTable extends Table
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

        $this->setTable('remediation_seances');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Remediations', [
            'foreignKey' => 'remediation_id',
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
            ->allowEmpty('type');

        $validator
            ->allowEmpty('status');

        $validator
            ->date('date')
            ->allowEmpty('date');

        $validator
            ->numeric('debut')
            ->allowEmpty('debut');

        $validator
            ->numeric('duree')
            ->allowEmpty('duree');

        $validator
            ->scalar('contenu')
            ->allowEmpty('contenu');

        $validator
            ->numeric('note')
            ->allowEmpty('note');

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
        $rules->add($rules->existsIn(['remediation_id'], 'Remediations'));

        return $rules;
    }
}
