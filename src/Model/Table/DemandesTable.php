<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Demandes Model
 *
 * @property \App\Model\Table\TuteursTable|\Cake\ORM\Association\BelongsTo $Tuteurs
 *
 * @method \App\Model\Entity\Demande get($primaryKey, $options = [])
 * @method \App\Model\Entity\Demande newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Demande[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Demande|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Demande|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Demande patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Demande[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Demande findOrCreate($search, callable $callback = null, $options = [])
 */
class DemandesTable extends Table
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

        $this->setTable('demandes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tuteurs', [
            'foreignKey' => 'tuteur_id',
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
            ->maxLength('type', 100)
            ->allowEmpty('type');

        $validator
            ->scalar('texte')
            ->allowEmpty('texte');

        $validator
            ->scalar('etat')
            ->maxLength('etat', 45)
            ->allowEmpty('etat');

        $validator
            ->date('date')
            ->allowEmpty('date');

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
        $rules->add($rules->existsIn(['tuteur_id'], 'Tuteurs'));

        return $rules;
    }
}
