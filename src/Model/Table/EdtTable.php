<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Edt Model
 *
 * @property \App\Model\Table\SallesTable|\Cake\ORM\Association\BelongsTo $Salles
 * @property \App\Model\Table\CoursTable|\Cake\ORM\Association\BelongsTo $Cours
 *
 * @method \App\Model\Entity\Edt get($primaryKey, $options = [])
 * @method \App\Model\Entity\Edt newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Edt[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Edt|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Edt|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Edt patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Edt[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Edt findOrCreate($search, callable $callback = null, $options = [])
 */
class EdtTable extends Table
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

        $this->setTable('edt');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Salles', [
            'foreignKey' => 'salle_id'
        ]);
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
            ->scalar('jour')
            ->maxLength('jour', 10)
            ->allowEmpty('jour');

        $validator
            ->numeric('debut')
            ->allowEmpty('debut');

        $validator
            ->numeric('duree')
            ->allowEmpty('duree');

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
        $rules->add($rules->existsIn(['salle_id'], 'Salles'));
        $rules->add($rules->existsIn(['cours_id'], 'Cours'));

        return $rules;
    }
}
