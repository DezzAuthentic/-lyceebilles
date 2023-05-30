<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TuteurSecondaires Model
 *
 * @property \App\Model\Table\TuteursTable|\Cake\ORM\Association\BelongsTo $Tuteurs
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\TuteurSecondaire get($primaryKey, $options = [])
 * @method \App\Model\Entity\TuteurSecondaire newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\TuteurSecondaire[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TuteurSecondaire|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TuteurSecondaire|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TuteurSecondaire patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TuteurSecondaire[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\TuteurSecondaire findOrCreate($search, callable $callback = null, $options = [])
 */
class TuteurSecondairesTable extends Table
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

        $this->setTable('tuteur_secondaires');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tuteurs', [
            'foreignKey' => 'tuteur_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->maxLength('nom', 45)
            ->allowEmpty('nom');

        $validator
            ->scalar('prenom')
            ->maxLength('prenom', 45)
            ->allowEmpty('prenom');

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
        $rules->add($rules->existsIn(['tuteur_id'], 'Tuteurs'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
