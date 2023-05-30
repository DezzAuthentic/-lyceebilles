<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Professeurs Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property |\Cake\ORM\Association\BelongsTo $Etablissements
 * @property \App\Model\Table\CoursTable|\Cake\ORM\Association\HasMany $Cours
 * @property \App\Model\Table\EnseigneesTable|\Cake\ORM\Association\HasMany $Enseignees
 *
 * @method \App\Model\Entity\Professeur get($primaryKey, $options = [])
 * @method \App\Model\Entity\Professeur newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Professeur[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Professeur|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Professeur|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Professeur patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Professeur[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Professeur findOrCreate($search, callable $callback = null, $options = [])
 */
class ProfesseursTable extends Table
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

        $this->setTable('professeurs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Etablissements', [
            'foreignKey' => 'etablissement_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Cours', [
            'foreignKey' => 'professeur_id'
        ]);
        $this->hasMany('Enseignees', [
            'foreignKey' => 'professeur_id'
        ]);
        $this->hasMany('Matieres', [
            'foreignKey' => 'professeur_id'
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

        $validator
            ->scalar('adresse')
            ->maxLength('adresse', 100)
            ->allowEmpty('adresse');

        $validator
            ->scalar('telephone')
            ->maxLength('telephone', 20)
            ->allowEmpty('telephone');

        $validator
            ->date('date_naissance')
            ->allowEmpty('date_naissance');

        $validator
            ->date('date_debut')
            ->allowEmpty('date_debut');

        $validator
            ->scalar('genre')
            ->maxLength('genre', 1)
            ->allowEmpty('genre');

        $validator
            ->integer('etat')
            ->allowEmpty('etat');

        $validator
            ->scalar('photo')
            ->maxLength('photo', 255)
            ->allowEmpty('photo');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['etablissement_id'], 'Etablissements'));

        return $rules;
    }
}
