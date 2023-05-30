<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Engagements Model
 *
 * @property \App\Model\Table\FraisTable|\Cake\ORM\Association\BelongsTo $Frais
 * @property \App\Model\Table\InscriptionsTable|\Cake\ORM\Association\BelongsTo $Inscriptions
 * @property |\Cake\ORM\Association\HasMany $Factures
 *
 * @method \App\Model\Entity\Engagement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Engagement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Engagement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Engagement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Engagement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Engagement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Engagement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Engagement findOrCreate($search, callable $callback = null, $options = [])
 */
class EngagementsTable extends Table
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

        $this->setTable('engagements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Frais', [
            'foreignKey' => 'frais_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Inscriptions', [
            'foreignKey' => 'inscription_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Debut', [
            'foreignKey' => 'debut',
            'joinType' => 'INNER',
            'propertyName' => 'mois_debut',
            'className' => 'Mois'
        ]);

        $this->belongsTo('Fin', [
            'foreignKey' => 'fin',
            'joinType' => 'INNER',
            'propertyName' => 'mois_fin',
            'className' => 'Mois'
        ]);

        $this->hasMany('Factures', [
            'foreignKey' => 'engagement_id'
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
            ->integer('debut')
            ->requirePresence('debut', 'create')
            ->notEmpty('debut');

        $validator
            ->integer('fin')
            ->requirePresence('fin', 'create')
            ->notEmpty('fin');

        $validator
            ->numeric('reduction')
            ->allowEmpty('reduction');

        $validator
            ->numeric('parrainage')
            ->allowEmpty('parrainage');

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
        $rules->add($rules->existsIn(['frais_id'], 'Frais'));
        $rules->add($rules->existsIn(['inscription_id'], 'Inscriptions'));

        return $rules;
    }
}
