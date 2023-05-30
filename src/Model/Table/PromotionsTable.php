<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Promotions Model
 *
 * @property \App\Model\Table\AnneesTable|\Cake\ORM\Association\BelongsTo $Annees
 * @property \App\Model\Table\NiveauxTable|\Cake\ORM\Association\BelongsTo $Niveaux
 * @property \App\Model\Table\SeriesTable|\Cake\ORM\Association\BelongsTo $Series
 * @property \App\Model\Table\CoefficientsTable|\Cake\ORM\Association\HasMany $Coefficients
 * @property \App\Model\Table\GroupesTable|\Cake\ORM\Association\HasMany $Groupes
 * @property \App\Model\Table\InscriptionFraisTable|\Cake\ORM\Association\HasMany $InscriptionFrais
 * @property \App\Model\Table\InscriptionsTable|\Cake\ORM\Association\HasMany $Inscriptions
 * @property \App\Model\Table\TestsTable|\Cake\ORM\Association\HasMany $Tests
 *
 * @method \App\Model\Entity\Promotion get($primaryKey, $options = [])
 * @method \App\Model\Entity\Promotion newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Promotion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Promotion|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Promotion|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Promotion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Promotion[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Promotion findOrCreate($search, callable $callback = null, $options = [])
 */
class PromotionsTable extends Table
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

        $this->setTable('promotions');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->belongsTo('Annees', [
            'foreignKey' => 'annee_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Niveaux', [
            'foreignKey' => 'niveau_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Series', [
            'foreignKey' => 'serie_id'
        ]);
        $this->hasMany('Coefficients', [
            'foreignKey' => 'promotion_id'
        ]);
        $this->hasMany('Groupes', [
            'foreignKey' => 'promotion_id'
        ]);
        $this->hasMany('InscriptionFrais', [
            'foreignKey' => 'promotion_id'
        ]);
        $this->hasMany('Inscriptions', [
            'foreignKey' => 'promotion_id'
        ]);
        $this->hasMany('Tests', [
            'foreignKey' => 'promotion_id'
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
            ->maxLength('nom', 100)
            ->allowEmpty('nom');

        $validator
            ->integer('montant_inscription')
            ->allowEmpty('montant_inscription');

        $validator
            ->numeric('moyenne_test')
            ->allowEmpty('moyenne_test');

        $validator
            ->integer('scolarite')
            ->allowEmpty('scolarite');

        $validator
            ->integer('effectif')
            ->allowEmpty('effectif');

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
        $rules->add($rules->existsIn(['annee_id'], 'Annees'));
        $rules->add($rules->existsIn(['niveau_id'], 'Niveaux'));
        $rules->add($rules->existsIn(['serie_id'], 'Series'));

        return $rules;
    }
}
