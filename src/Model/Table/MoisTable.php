<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mois Model
 *
 * @property \App\Model\Table\EtablissementsTable|\Cake\ORM\Association\BelongsTo $Etablissements
 * @property \App\Model\Table\EngagementsTable|\Cake\ORM\Association\HasMany $Engagements
 * @property \App\Model\Table\FacturesTable|\Cake\ORM\Association\HasMany $Factures
 *
 * @method \App\Model\Entity\Mois get($primaryKey, $options = [])
 * @method \App\Model\Entity\Mois newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Mois[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Mois|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mois|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Mois patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Mois[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Mois findOrCreate($search, callable $callback = null, $options = [])
 */
class MoisTable extends Table
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

        $this->setTable('mois');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->belongsTo('Etablissements', [
            'foreignKey' => 'etablissement_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Engagements', [
            'foreignKey' => 'mois_id'
        ]);
        $this->hasMany('Factures', [
            'foreignKey' => 'mois_id'
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
            ->maxLength('nom', 10)
            ->allowEmpty('nom');

        $validator
            ->integer('ordre')
            ->allowEmpty('ordre')
            ->add('ordre', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('code')
            ->maxLength('code', 2)
            ->allowEmpty('code');

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
        $rules->add($rules->isUnique(['ordre']));
        $rules->add($rules->existsIn(['etablissement_id'], 'Etablissements'));

        return $rules;
    }
}
