<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Etablissements Model
 *
 * @property \App\Model\Table\ConfigurationsTable|\Cake\ORM\Association\BelongsTo $Configurations
 * @property \App\Model\Table\EmployesTable|\Cake\ORM\Association\BelongsTo $Employes
 * @property \App\Model\Table\AnneesTable|\Cake\ORM\Association\BelongsTo $Annees
 * @property \App\Model\Table\AnneesTable|\Cake\ORM\Association\HasMany $Annees
 * @property \App\Model\Table\ElevesTable|\Cake\ORM\Association\HasMany $Eleves
 * @property \App\Model\Table\EmployesTable|\Cake\ORM\Association\HasMany $Employes
 * @property \App\Model\Table\MatieresTable|\Cake\ORM\Association\HasMany $Matieres
 * @property \App\Model\Table\NiveauxTable|\Cake\ORM\Association\HasMany $Niveaux
 * @property \App\Model\Table\ProfesseursTable|\Cake\ORM\Association\HasMany $Professeurs
 * @property \App\Model\Table\SallesTable|\Cake\ORM\Association\HasMany $Salles
 * @property \App\Model\Table\SeriesTable|\Cake\ORM\Association\HasMany $Series
 * @property \App\Model\Table\TuteursTable|\Cake\ORM\Association\HasMany $Tuteurs
 *
 * @method \App\Model\Entity\Etablissement get($primaryKey, $options = [])
 * @method \App\Model\Entity\Etablissement newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Etablissement[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Etablissement|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Etablissement|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Etablissement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Etablissement[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Etablissement findOrCreate($search, callable $callback = null, $options = [])
 */
class EtablissementsTable extends Table
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

        $this->setTable('etablissements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Configurations', [
            'foreignKey' => 'configuration_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Employes', [
            'foreignKey' => 'admin_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Annees', [
            'foreignKey' => 'annee_id'
        ]);
        $this->hasMany('Annees', [
            'foreignKey' => 'etablissement_id'
        ]);
        $this->hasMany('Eleves', [
            'foreignKey' => 'etablissement_id'
        ]);
        $this->hasMany('Employes', [
            'foreignKey' => 'etablissement_id'
        ]);
        $this->hasMany('Matieres', [
            'foreignKey' => 'etablissement_id'
        ]);
        $this->hasMany('Niveaux', [
            'foreignKey' => 'etablissement_id'
        ]);
        $this->hasMany('Professeurs', [
            'foreignKey' => 'etablissement_id'
        ]);
        $this->hasMany('Salles', [
            'foreignKey' => 'etablissement_id'
        ]);
        $this->hasMany('Series', [
            'foreignKey' => 'etablissement_id'
        ]);
        $this->hasMany('Tuteurs', [
            'foreignKey' => 'etablissement_id'
        ]);
        $this->hasMany('Types', [
            'foreignKey' => 'etablissement_id'
        ]);
        $this->hasMany('Mois', [
            'foreignKey' => 'etablissement_id'
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
            ->maxLength('nom', 255)
            ->allowEmpty('nom');

        $validator
            ->scalar('adresse')
            ->maxLength('adresse', 255)
            ->allowEmpty('adresse');

        $validator
            ->scalar('tel')
            ->maxLength('tel', 15)
            ->allowEmpty('tel');

        $validator
            ->email('email')
            ->allowEmpty('email');

        $validator
            ->scalar('logo')
            ->maxLength('logo', 255)
            ->allowEmpty('logo');

        $validator
            ->scalar('couverture')
            ->maxLength('couverture', 255)
            ->allowEmpty('couverture');

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
        $rules->add($rules->existsIn(['configuration_id'], 'Configurations'));
        $rules->add($rules->existsIn(['admin_id'], 'Employes'));
        $rules->add($rules->existsIn(['annee_id'], 'Annees'));

        return $rules;
    }
}
