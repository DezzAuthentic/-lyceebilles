<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Desserts Model
 *
 * @property \App\Model\Table\EtablissementsTable|\Cake\ORM\Association\BelongsTo $Etablissements
 * @property \App\Model\Table\MenusTable|\Cake\ORM\Association\HasMany $Menus
 *
 * @method \App\Model\Entity\Dessert get($primaryKey, $options = [])
 * @method \App\Model\Entity\Dessert newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Dessert[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Dessert|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dessert|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Dessert patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Dessert[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Dessert findOrCreate($search, callable $callback = null, $options = [])
 */
class DessertsTable extends Table
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

        $this->setTable('desserts');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->belongsTo('Etablissements', [
            'foreignKey' => 'etablissement_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Menus', [
            'foreignKey' => 'dessert_id'
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
