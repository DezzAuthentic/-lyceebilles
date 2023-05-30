<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Affectations Model
 *
 * @property \App\Model\Table\GroupesTable|\Cake\ORM\Association\BelongsTo $Groupes
 * @property \App\Model\Table\InscriptionsTable|\Cake\ORM\Association\BelongsTo $Inscriptions
 * @property |\Cake\ORM\Association\HasMany $AnneeBulletins
 * @property \App\Model\Table\PeriodeBulletinsTable|\Cake\ORM\Association\HasMany $PeriodeBulletins
 *
 * @method \App\Model\Entity\Affectation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Affectation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Affectation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Affectation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Affectation|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Affectation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Affectation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Affectation findOrCreate($search, callable $callback = null, $options = [])
 */
class AffectationsTable extends Table
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

        $this->setTable('affectations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Groupes', [
            'foreignKey' => 'groupe_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Inscriptions', [
            'foreignKey' => 'inscription_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AnneeBulletins', [
            'foreignKey' => 'affectation_id'
        ]);
        $this->hasMany('PeriodeBulletins', [
            'foreignKey' => 'affectation_id'
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
            ->date('date')
            ->allowEmpty('date');

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
        $rules->add($rules->existsIn(['groupe_id'], 'Groupes'));
        $rules->add($rules->existsIn(['inscription_id'], 'Inscriptions'));

        return $rules;
    }
}
