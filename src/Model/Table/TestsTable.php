<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tests Model
 *
 * @property \App\Model\Table\PromotionsTable|\Cake\ORM\Association\BelongsTo $Promotions
 * @property \App\Model\Table\ElevesTable|\Cake\ORM\Association\BelongsTo $Eleves
 * @property \App\Model\Table\MatieresTable|\Cake\ORM\Association\BelongsTo $Matieres
 *
 * @method \App\Model\Entity\Test get($primaryKey, $options = [])
 * @method \App\Model\Entity\Test newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Test[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Test|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Test|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Test patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Test[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Test findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TestsTable extends Table
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

        $this->setTable('tests');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Promotions', [
            'foreignKey' => 'promotion_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Eleves', [
            'foreignKey' => 'eleve_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Matieres', [
            'foreignKey' => 'matiere_id',
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
            ->numeric('note')
            ->allowEmpty('note');

        $validator
            ->scalar('appreciation')
            ->maxLength('appreciation', 100)
            ->allowEmpty('appreciation');

        $validator
            ->allowEmpty('status');

        $validator
            ->date('date')
            ->allowEmpty('date');

        $validator
            ->scalar('heure')
            ->maxLength('heure', 10)
            ->allowEmpty('heure');

        $validator
            ->scalar('duree')
            ->maxLength('duree', 8)
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
        $rules->add($rules->existsIn(['promotion_id'], 'Promotions'));
        $rules->add($rules->existsIn(['eleve_id'], 'Eleves'));
        $rules->add($rules->existsIn(['matiere_id'], 'Matieres'));

        return $rules;
    }
}
