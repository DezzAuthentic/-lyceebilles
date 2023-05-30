<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Salles Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Etablissements
 * @property \App\Model\Table\EdtTable|\Cake\ORM\Association\HasMany $Edt
 * @property \App\Model\Table\GroupesTable|\Cake\ORM\Association\HasMany $Groupes
 * @property \App\Model\Table\SeancesTable|\Cake\ORM\Association\HasMany $Seances
 *
 * @method \App\Model\Entity\Salle get($primaryKey, $options = [])
 * @method \App\Model\Entity\Salle newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Salle[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Salle|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Salle|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Salle patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Salle[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Salle findOrCreate($search, callable $callback = null, $options = [])
 */
class SallesTable extends Table
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

        $this->setTable('salles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Etablissements', [
            'foreignKey' => 'etablissement_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Edt', [
            'foreignKey' => 'salle_id'
        ]);
        $this->hasMany('Groupes', [
            'foreignKey' => 'salle_id'
        ]);
        $this->hasMany('Seances', [
            'foreignKey' => 'salle_id'
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
            ->scalar('pavillon')
            ->maxLength('pavillon', 45)
            ->allowEmpty('pavillon');

        $validator
            ->scalar('etage')
            ->maxLength('etage', 45)
            ->allowEmpty('etage');

        $validator
            ->integer('capacite')
            ->allowEmpty('capacite');

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
