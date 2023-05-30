<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RenseignementTypes Model
 *
 * @property \App\Model\Table\EtablissementsTable|\Cake\ORM\Association\BelongsTo $Etablissements
 * @property \App\Model\Table\RenseignementsTable|\Cake\ORM\Association\HasMany $Renseignements
 *
 * @method \App\Model\Entity\RenseignementType get($primaryKey, $options = [])
 * @method \App\Model\Entity\RenseignementType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\RenseignementType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\RenseignementType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RenseignementType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\RenseignementType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\RenseignementType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\RenseignementType findOrCreate($search, callable $callback = null, $options = [])
 */
class RenseignementTypesTable extends Table
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

        $this->setTable('renseignement_types');
        $this->setDisplayField('libelle');
        $this->setPrimaryKey('id');

        $this->belongsTo('Etablissements', [
            'foreignKey' => 'etablissement_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Renseignements', [
            'foreignKey' => 'renseignement_type_id'
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
        $rules->add($rules->existsIn(['etablissement_id'], 'Etablissements'));

        return $rules;
    }
}
