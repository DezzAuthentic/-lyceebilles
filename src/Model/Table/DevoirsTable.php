<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Devoirs Model
 *
 * @property \App\Model\Table\CoursTable|\Cake\ORM\Association\BelongsTo $Cours
 * @property |\Cake\ORM\Association\BelongsTo $Periodes
 * @property \App\Model\Table\DevoirNotesTable|\Cake\ORM\Association\HasMany $DevoirNotes
 *
 * @method \App\Model\Entity\Devoir get($primaryKey, $options = [])
 * @method \App\Model\Entity\Devoir newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Devoir[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Devoir|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Devoir|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Devoir patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Devoir[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Devoir findOrCreate($search, callable $callback = null, $options = [])
 */
class DevoirsTable extends Table
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

        $this->setTable('devoirs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cours', [
            'foreignKey' => 'cours_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Periodes', [
            'foreignKey' => 'periode_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('DevoirNotes', [
            'foreignKey' => 'devoir_id'
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
            ->dateTime('date')
            ->allowEmpty('date');

        $validator
            ->numeric('duree')
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
        $rules->add($rules->existsIn(['periode_id'], 'Periodes'));

        return $rules;
    }
}
