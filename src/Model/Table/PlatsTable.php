<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Plats Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Etablissements
 * @property \App\Model\Table\MenusTable|\Cake\ORM\Association\HasMany $Menus
 *
 * @method \App\Model\Entity\Plat get($primaryKey, $options = [])
 * @method \App\Model\Entity\Plat newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Plat[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Plat|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Plat|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Plat patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Plat[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Plat findOrCreate($search, callable $callback = null, $options = [])
 */
class PlatsTable extends Table
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

        $this->setTable('plats');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->belongsTo('Etablissements', [
            'foreignKey' => 'etablissement_id'
        ]);
        $this->hasMany('Menus', [
            'foreignKey' => 'plat_id'
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
