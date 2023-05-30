<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Factures Model
 *
 * @property \App\Model\Table\MoisTable|\Cake\ORM\Association\BelongsTo $Mois
 * @property \App\Model\Table\InscriptionsTable|\Cake\ORM\Association\BelongsTo $Inscriptions
 * @property \App\Model\Table\FraisTable|\Cake\ORM\Association\BelongsTo $Frais
 * @property \App\Model\Table\EngagementsTable|\Cake\ORM\Association\BelongsTo $Engagements
 * @property \App\Model\Table\ReglementsTable|\Cake\ORM\Association\HasMany $Reglements
 *
 * @method \App\Model\Entity\Facture get($primaryKey, $options = [])
 * @method \App\Model\Entity\Facture newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Facture[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Facture|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Facture|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Facture patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Facture[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Facture findOrCreate($search, callable $callback = null, $options = [])
 */
class FacturesTable extends Table
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

        $this->setTable('factures');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Mois', [
            'foreignKey' => 'mois_id'
        ]);
        $this->belongsTo('Inscriptions', [
            'foreignKey' => 'inscription_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Frais', [
            'foreignKey' => 'frais_id'
        ]);
        $this->belongsTo('Engagements', [
            'foreignKey' => 'engagement_id'
        ]);
        $this->hasMany('Reglements', [
            'foreignKey' => 'facture_id'
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
            ->integer('montant')
            ->allowEmpty('montant');

        $validator
            ->integer('paye')
            ->allowEmpty('paye');

        $validator
            ->integer('restant')
            ->allowEmpty('restant');

        $validator
            ->dateTime('date')
            ->allowEmpty('date');

        $validator
            ->scalar('details')
            ->maxLength('details', 100)
            ->allowEmpty('details');

        $validator
            ->integer('parrainage')
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
        $rules->add($rules->existsIn(['mois_id'], 'Mois'));
        $rules->add($rules->existsIn(['inscription_id'], 'Inscriptions'));
        $rules->add($rules->existsIn(['frais_id'], 'Frais'));
        $rules->add($rules->existsIn(['engagement_id'], 'Engagements'));

        return $rules;
    }
}
