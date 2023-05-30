<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Niveaux Model
 *
 * @property \App\Model\Table\EtablissementsTable|\Cake\ORM\Association\BelongsTo $Etablissements
 *
 * @method \App\Model\Entity\Niveaux get($primaryKey, $options = [])
 * @method \App\Model\Entity\Niveaux newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Niveaux[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Niveaux|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Niveaux|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Niveaux patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Niveaux[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Niveaux findOrCreate($search, callable $callback = null, $options = [])
 */
class NiveauxTable extends Table
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

        $this->setTable('niveaux');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->belongsTo('Etablissements', [
            'foreignKey' => 'etablissement_id',
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
            ->scalar('nom')
            ->maxLength('nom', 45)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        /*$validator
            ->integer('ordre')
            ->allowEmpty('ordre')
            ->add('ordre','unique', ['rule' => 'validateUnique', 'provider' => 'table']);*/

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
        //$rules->add($rules->isUnique(['ordre']));

        return $rules;
    }
}
