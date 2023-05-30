<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Enseignees Model
 *
 * @property \App\Model\Table\MatieresTable|\Cake\ORM\Association\BelongsTo $Matieres
 * @property \App\Model\Table\ProfesseursTable|\Cake\ORM\Association\BelongsTo $Professeurs
 *
 * @method \App\Model\Entity\Enseignee get($primaryKey, $options = [])
 * @method \App\Model\Entity\Enseignee newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Enseignee[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Enseignee|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Enseignee|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Enseignee patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Enseignee[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Enseignee findOrCreate($search, callable $callback = null, $options = [])
 */
class EnseigneesTable extends Table
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

        $this->setTable('enseignees');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Matieres', [
            'foreignKey' => 'matiere_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Professeurs', [
            'foreignKey' => 'professeur_id',
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
            ->scalar('nom')
            ->maxLength('nom', 100)
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
        $rules->add($rules->existsIn(['matiere_id'], 'Matieres'));
        $rules->add($rules->existsIn(['professeur_id'], 'Professeurs'));

        return $rules;
    }
}
