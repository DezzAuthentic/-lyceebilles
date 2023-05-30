<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Inscriptions Model
 *
 * @property \App\Model\Table\ElevesTable|\Cake\ORM\Association\BelongsTo $Eleves
 * @property \App\Model\Table\PromotionsTable|\Cake\ORM\Association\BelongsTo $Promotions
 * @property \App\Model\Table\AffectationsTable|\Cake\ORM\Association\HasMany $Affectations
 * @property \App\Model\Table\EngagementsTable|\Cake\ORM\Association\HasMany $Engagements
 * @property |\Cake\ORM\Association\HasMany $Factures
 *
 * @method \App\Model\Entity\Inscription get($primaryKey, $options = [])
 * @method \App\Model\Entity\Inscription newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Inscription[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Inscription|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Inscription|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Inscription patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Inscription[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Inscription findOrCreate($search, callable $callback = null, $options = [])
 */
class InscriptionsTable extends Table
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

        $this->setTable('inscriptions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Eleves', [
            'foreignKey' => 'eleve_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Promotions', [
            'foreignKey' => 'promotion_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Affectations', [
            'foreignKey' => 'inscription_id'
        ]);
        $this->hasMany('Engagements', [
            'foreignKey' => 'inscription_id'
        ]);
        $this->hasMany('Factures', [
            'foreignKey' => 'inscription_id'
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
            ->date('date')
            ->allowEmpty('date');

        $validator
            ->scalar('etat')
            ->maxLength('etat', 30)
            ->allowEmpty('etat');

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
        $rules->add($rules->existsIn(['eleve_id'], 'Eleves'));
        $rules->add($rules->existsIn(['promotion_id'], 'Promotions'));

        return $rules;
    }
}
