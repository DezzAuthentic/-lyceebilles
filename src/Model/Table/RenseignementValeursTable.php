<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RenseignementValeurs Model
 *
 * @property \App\Model\Table\RenseignementsTable|\Cake\ORM\Association\BelongsTo $Renseignements
 * @property \App\Model\Table\ElevesTable|\Cake\ORM\Association\BelongsTo $Eleves
 *
 * @method \App\Model\Entity\RenseignementValeur get($primaryKey, $options = [])
 * @method \App\Model\Entity\RenseignementValeur newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RenseignementValeur[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RenseignementValeur|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RenseignementValeur|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RenseignementValeur patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RenseignementValeur[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RenseignementValeur findOrCreate($search, callable $callback = null, $options = [])
 */
class RenseignementValeursTable extends Table
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

        $this->setTable('renseignement_valeurs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Renseignements', [
            'foreignKey' => 'renseignement_id',
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
            ->allowEmpty('valeur');

        $validator
            ->scalar('commentaire')
            ->maxLength('commentaire', 100)
            ->allowEmpty('commentaire');

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
        $rules->add($rules->existsIn(['renseignement_id'], 'Renseignements'));
        $rules->add($rules->existsIn(['eleve_id'], 'Eleves'));

        return $rules;
    }
}
