<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Frais Model
 *
 * @property \App\Model\Table\TypesTable|\Cake\ORM\Association\BelongsTo $Types
 * @property \App\Model\Table\NiveauxTable|\Cake\ORM\Association\BelongsTo $Niveaux
 * @property \App\Model\Table\SeriesTable|\Cake\ORM\Association\BelongsTo $Series
 *
 * @method \App\Model\Entity\Frai get($primaryKey, $options = [])
 * @method \App\Model\Entity\Frai newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Frai[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Frai|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Frai|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Frai patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Frai[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Frai findOrCreate($search, callable $callback = null, $options = [])
 */
class FraisTable extends Table
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

        $this->setTable('frais');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Types', [
            'foreignKey' => 'type_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Niveaux', [
            'foreignKey' => 'niveau_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Series', [
            'foreignKey' => 'serie_id'
        ]);
        $this->hasMany('Engagements', [
            'foreignKey' => 'frais_id'
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
            ->allowEmpty('nom');

        $validator
            ->integer('montant')
            ->allowEmpty('montant');

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
        $rules->add($rules->existsIn(['type_id'], 'Types'));
        $rules->add($rules->existsIn(['niveau_id'], 'Niveaux'));
        $rules->add($rules->existsIn(['serie_id'], 'Series'));

        return $rules;
    }
}
