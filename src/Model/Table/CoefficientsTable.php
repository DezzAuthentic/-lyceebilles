<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Coefficients Model
 *
 * @property |\Cake\ORM\Association\BelongsTo $Matieres
 * @property \App\Model\Table\NiveauxTable|\Cake\ORM\Association\BelongsTo $Niveaux
 * @property \App\Model\Table\SeriesTable|\Cake\ORM\Association\BelongsTo $Series
 *
 * @method \App\Model\Entity\Coefficient get($primaryKey, $options = [])
 * @method \App\Model\Entity\Coefficient newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Coefficient[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Coefficient|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Coefficient|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Coefficient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Coefficient[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Coefficient findOrCreate($search, callable $callback = null, $options = [])
 */
class CoefficientsTable extends Table
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

        $this->setTable('coefficients');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Matieres', [
            'foreignKey' => 'matiere_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Niveaux', [
            'foreignKey' => 'niveau_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Series', [
            'foreignKey' => 'serie_id'
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
            ->integer('coef')
            ->allowEmpty('coef');

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
        $rules->add($rules->existsIn(['matiere_id'], 'Matieres'));
        $rules->add($rules->existsIn(['niveau_id'], 'Niveaux'));
        $rules->add($rules->existsIn(['serie_id'], 'Series'));

        return $rules;
    }
}
