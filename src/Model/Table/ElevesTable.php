<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Eleves Model
 *
 * @property \App\Model\Table\TuteursTable|\Cake\ORM\Association\BelongsTo $Tuteurs
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\EtablissementsTable|\Cake\ORM\Association\BelongsTo $Etablissements
 * @property \App\Model\Table\InscriptionsTable|\Cake\ORM\Association\HasMany $inscriptions
 *
 * @method \App\Model\Entity\Elef get($primaryKey, $options = [])
 * @method \App\Model\Entity\Elef newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Elef[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Elef|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Elef|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Elef patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Elef[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Elef findOrCreate($search, callable $callback = null, $options = [])
 */
class ElevesTable extends Table
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

        $this->setTable('eleves');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tuteurs', [
            'foreignKey' => 'tuteur_id'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('Etablissements', [
            'foreignKey' => 'etablissement_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Inscriptions', [
            'foreignKey' => 'eleve_id',
        ]);
        $this->hasMany('Renseignement_valeurs', [
            'foreignKey' => 'eleve_id',
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
            ->scalar('matricule')
            ->maxLength('matricule', 20)
            ->allowEmpty('matricule');

        $validator
            ->scalar('nom')
            ->maxLength('nom', 45)
            ->allowEmpty('nom');

        $validator
            ->scalar('prenom')
            ->maxLength('prenom', 100)
            ->allowEmpty('prenom');

        $validator
            ->scalar('genre')
            ->maxLength('genre', 1)
            ->allowEmpty('genre');

        $validator
            ->date('date_naissance')
            ->allowEmpty('date_naissance');

        $validator
            ->scalar('lieu_naissance')
            ->maxLength('lieu_naissance', 100)
            ->allowEmpty('lieu_naissance');

        $validator
            ->scalar('telephone')
            ->maxLength('telephone', 20)
            ->allowEmpty('telephone');

        $validator
            ->scalar('adresse')
            ->maxLength('adresse', 255)
            ->allowEmpty('adresse');

        $validator
            ->integer('pays_naissance')
            ->allowEmpty('pays_naissance');

        $validator
            ->integer('nationalite')
            ->allowEmpty('nationalite');

        $validator
            ->scalar('Religion')
            ->maxLength('Religion', 15)
            ->allowEmpty('Religion');

        $validator
            ->integer('cours_religion')
            ->allowEmpty('cours_religion');

        $validator
            ->scalar('photo')
            ->maxLength('photo', 255)
            ->allowEmpty('photo');

        $validator
            ->scalar('pere')
            ->maxLength('pere', 45)
            ->allowEmpty('pere');

        $validator
            ->scalar('mere')
            ->maxLength('mere', 45)
            ->allowEmpty('mere');

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
        $rules->add($rules->existsIn(['etablissement_id'], 'Etablissements'));

        return $rules;
    }
}
