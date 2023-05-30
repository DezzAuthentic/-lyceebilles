<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\ElevesTable|\Cake\ORM\Association\HasMany $Eleves
 * @property \App\Model\Table\EmployesTable|\Cake\ORM\Association\HasMany $Employes
 * @property \App\Model\Table\EmpruntsTable|\Cake\ORM\Association\HasMany $Emprunts
 * @property \App\Model\Table\ProfesseursTable|\Cake\ORM\Association\HasMany $Professeurs
 * @property |\Cake\ORM\Association\HasMany $Reglements
 * @property \App\Model\Table\TuteursTable|\Cake\ORM\Association\HasMany $Tuteurs
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Eleves', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Employes', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Emprunts', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Professeurs', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Reglements', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Tuteurs', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('TuteurSecondaires', [
            'foreignKey' => 'user_id'
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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->scalar('profil')
            ->maxLength('profil', 15)
            ->allowEmpty('profil');

        $validator
            ->dateTime('creatime')
            ->allowEmpty('creatime');

        $validator
            ->integer('etat')
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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['creatime']));

        return $rules;
    }
}
