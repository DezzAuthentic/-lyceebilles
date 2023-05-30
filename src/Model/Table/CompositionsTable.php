<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Compositions Model
 *
 * @property \App\Model\Table\CoursTable|\Cake\ORM\Association\BelongsTo $Cours
 *
 * @method \App\Model\Entity\Composition get($primaryKey, $options = [])
 * @method \App\Model\Entity\Composition newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Composition[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Composition|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Composition|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Composition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Composition[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Composition findOrCreate($search, callable $callback = null, $options = [])
 */
class CompositionsTable extends Table
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

        $this->setTable('compositions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cours', [
            'foreignKey' => 'cours_id',
            'joinType' => 'INNER'
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
            ->dateTime('date')
            ->allowEmpty('date');

        $validator
            ->integer('duree')
            ->allowEmpty('duree');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

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
        $rules->add($rules->existsIn(['cours_id'], 'Cours'));

        return $rules;
    }
}
