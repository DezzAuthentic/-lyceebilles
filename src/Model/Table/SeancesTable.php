<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Seances Model
 *
 * @property \App\Model\Table\CoursTable|\Cake\ORM\Association\BelongsTo $Cours
 * @property \App\Model\Table\SallesTable|\Cake\ORM\Association\BelongsTo $Salles
 * @property \App\Model\Table\ExercicesTable|\Cake\ORM\Association\HasMany $Exercices
 * @property \App\Model\Table\PresencesTable|\Cake\ORM\Association\HasMany $Presences
 *
 * @method \App\Model\Entity\Seance get($primaryKey, $options = [])
 * @method \App\Model\Entity\Seance newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Seance[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Seance|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Seance|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Seance patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Seance[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Seance findOrCreate($search, callable $callback = null, $options = [])
 */
class SeancesTable extends Table
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

        $this->setTable('seances');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Cours', [
            'foreignKey' => 'cours_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Salles', [
            'foreignKey' => 'salle_id'
        ]);
        $this->hasMany('Exercices', [
            'foreignKey' => 'seance_id'
        ]);
        $this->hasMany('Presences', [
            'foreignKey' => 'seance_id'
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

        $validator
            ->numeric('debut')
            ->allowEmpty('debut');

        $validator
            ->numeric('duree')
            ->allowEmpty('duree');

        $validator
            ->scalar('contenu')
            ->allowEmpty('contenu');

        $validator
            ->scalar('etat')
            ->maxLength('etat', 10)
            ->allowEmpty('etat');

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
        $rules->add($rules->existsIn(['salle_id'], 'Salles'));

        return $rules;
    }
}
