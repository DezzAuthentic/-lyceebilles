<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tuteurs Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property |\Cake\ORM\Association\BelongsTo $Etablissements
 * @property \App\Model\Table\DemandesTable|\Cake\ORM\Association\HasMany $Demandes
 * @property \App\Model\Table\ElevesTable|\Cake\ORM\Association\HasMany $Eleves
 *
 * @method \App\Model\Entity\Tuteur get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tuteur newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tuteur[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tuteur|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tuteur|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tuteur patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tuteur[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tuteur findOrCreate($search, callable $callback = null, $options = [])
 */
class TuteursTable extends Table
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

        $this->setTable('tuteurs');
        $this->setDisplayField('nomComplet');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Etablissements', [
            'foreignKey' => 'etablissement_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Demandes', [
            'foreignKey' => 'tuteur_id'
        ]);
        $this->hasMany('Eleves', [
            'foreignKey' => 'tuteur_id'
        ]);
        $this->hasMany('TuteurSecondaires', [
            'foreignKey' => 'tuteur_id'
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
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        $validator
            ->scalar('prenom')
            ->maxLength('prenom', 100)
            ->requirePresence('prenom', 'create')
            ->notEmpty('prenom');

        $validator
            ->scalar('telephone')
            ->maxLength('telephone', 20)
            ->requirePresence('telephone', 'create')
            ->notEmpty('telephone');

        $validator
            ->scalar('adresse')
            ->maxLength('adresse', 255)
            ->requirePresence('adresse', 'create')
            ->notEmpty('adresse');

        $validator
            ->scalar('entreprise')
            ->maxLength('entreprise', 45)
            ->allowEmpty('entreprise');

        $validator
            ->scalar('fonction')
            ->maxLength('fonction', 45)
            ->allowEmpty('fonction');

        $validator
            ->date('date_naissance')
            ->allowEmpty('date_naissance');

        $validator
            ->integer('nationalite')
            ->allowEmpty('nationalite');

        $validator
            ->scalar('situation_matrimoniale')
            ->maxLength('situation_matrimoniale', 20)
            ->allowEmpty('situation_matrimoniale');

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
