<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Renseignements Model
 *
 * @property \App\Model\Table\RenseignementTypesTable|\Cake\ORM\Association\BelongsTo $RenseignementTypes
 * @property \App\Model\Table\RenseignementValeursTable|\Cake\ORM\Association\HasMany $RenseignementValeurs
 *
 * @method \App\Model\Entity\Renseignement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Renseignement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Renseignement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Renseignement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Renseignement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Renseignement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Renseignement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Renseignement findOrCreate($search, callable $callback = null, $options = [])
 */
class RenseignementsTable extends Table
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

        $this->setTable('renseignements');
        $this->setDisplayField('libelle');
        $this->setPrimaryKey('id');

        $this->belongsTo('RenseignementTypes', [
            'foreignKey' => 'renseignement_type_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('RenseignementValeurs', [
            'foreignKey' => 'renseignement_id'
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
            ->scalar('libelle')
            ->maxLength('libelle', 45)
            ->allowEmpty('libelle');

        $validator
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['renseignement_type_id'], 'RenseignementTypes'));

        return $rules;
    }
}
