<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Annees Model
 *
 * @property \App\Model\Table\EtablissementsTable|\Cake\ORM\Association\BelongsTo $Etablissements
 * @property \App\Model\Table\EtablissementsTable|\Cake\ORM\Association\HasMany $Etablissements
 * @property \App\Model\Table\PeriodesTable|\Cake\ORM\Association\HasMany $Periodes
 * @property \App\Model\Table\PromotionsTable|\Cake\ORM\Association\HasMany $Promotions
 *
 * @method \App\Model\Entity\Annee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Annee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Annee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Annee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Annee|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Annee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Annee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Annee findOrCreate($search, callable $callback = null, $options = [])
 */
class AnneesTable extends Table
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

        $this->setTable('annees');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Etablissements', [
            'foreignKey' => 'etablissement_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Etablissements', [
            'foreignKey' => 'annee_id'
        ]);
        $this->hasMany('Periodes', [
            'foreignKey' => 'annee_id'
        ]);
        $this->hasMany('Promotions', [
            'foreignKey' => 'annee_id'
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

        $validator
            ->date('professeur_ouverture')
            ->allowEmpty('professeur_ouverture');

        $validator
            ->date('administration_ouverture')
            ->allowEmpty('administration_ouverture');

        $validator
            ->date('inscription_ouverture')
            ->allowEmpty('inscription_ouverture');

        $validator
            ->date('classe_ouverture')
            ->allowEmpty('classe_ouverture');

        $validator
            ->integer('debut')
            ->allowEmpty('debut');

        $validator
            ->integer('fin')
            ->allowEmpty('fin');

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
