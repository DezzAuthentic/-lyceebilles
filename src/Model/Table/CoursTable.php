<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cours Model
 *
 * @property \App\Model\Table\GroupesTable|\Cake\ORM\Association\BelongsTo $Groupes
 * @property \App\Model\Table\MatieresTable|\Cake\ORM\Association\BelongsTo $Matieres
 * @property \App\Model\Table\ProfesseursTable|\Cake\ORM\Association\BelongsTo $Professeurs
 *
 * @method \App\Model\Entity\Cour get($primaryKey, $options = [])
 * @method \App\Model\Entity\Cour newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Cour[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Cour|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cour|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Cour patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Cour[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Cour findOrCreate($search, callable $callback = null, $options = [])
 */
class CoursTable extends Table
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

        $this->setTable('cours');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Groupes', [
            'foreignKey' => 'groupe_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Matieres', [
            'foreignKey' => 'matiere_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Professeurs', [
            'foreignKey' => 'professeur_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Edt', [
            'foreignKey' => 'cours_id'
        ]);
        $this->hasMany('Seances', [
            'foreignKey' => 'cours_id'
        ]);
        $this->hasMany('Devoirs', [
            'foreignKey' => 'cours_id'
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
            ->integer('volume')
            ->allowEmpty('volume');

        $validator
            ->integer('volume_effectue')
            ->allowEmpty('volume_effectue');

        $validator
            ->scalar('contenu')
            ->allowEmpty('contenu');

        $validator
            ->scalar('pj')
            ->maxLength('pj', 225)
            ->allowEmpty('pj');

        $validator
            ->scalar('type')
            ->maxLength('type', 45)
            ->allowEmpty('type');

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
        $rules->add($rules->existsIn(['matiere_id'], 'Matieres'));
        $rules->add($rules->existsIn(['professeur_id'], 'Professeurs'));

        return $rules;
    }
}
