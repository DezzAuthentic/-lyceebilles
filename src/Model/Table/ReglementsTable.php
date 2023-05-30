<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reglements Model
 *
 * @property \App\Model\Table\FacturesTable|\Cake\ORM\Association\BelongsTo $Factures
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Reglement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reglement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Reglement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reglement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reglement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reglement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reglement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reglement findOrCreate($search, callable $callback = null, $options = [])
 */
class ReglementsTable extends Table
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

        $this->setTable('reglements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Factures', [
            'foreignKey' => 'facture_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->dateTime('date')
            ->allowEmpty('date');

        $validator
            ->integer('montant')
            ->allowEmpty('montant');

        $validator
            ->scalar('moyen')
            ->maxLength('moyen', 45)
            ->allowEmpty('moyen');

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
        $rules->add($rules->existsIn(['facture_id'], 'Factures'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
