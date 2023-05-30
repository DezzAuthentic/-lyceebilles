<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Remediations Model
 *
 * @property \App\Model\Table\ProfesseursTable|\Cake\ORM\Association\BelongsTo $Professeurs
 * @property \App\Model\Table\MatieresTable|\Cake\ORM\Association\BelongsTo $Matieres
 * @property \App\Model\Table\InscriptionsTable|\Cake\ORM\Association\BelongsTo $Inscriptions
 * @property \App\Model\Table\RemediationSeancesTable|\Cake\ORM\Association\HasMany $RemediationSeances
 *
 * @method \App\Model\Entity\Remediation get($primaryKey, $options = [])
 * @method \App\Model\Entity\Remediation newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Remediation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Remediation|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Remediation|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Remediation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Remediation[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Remediation findOrCreate($search, callable $callback = null, $options = [])
 */
class RemediationsTable extends Table
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

        $this->setTable('remediations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Professeurs', [
            'foreignKey' => 'professeur_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Matieres', [
            'foreignKey' => 'matiere_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Inscriptions', [
            'foreignKey' => 'inscription_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('RemediationSeances', [
            'foreignKey' => 'remediation_id'
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
            ->scalar('objet')
            ->maxLength('objet', 100)
            ->allowEmpty('objet');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['professeur_id'], 'Professeurs'));
        $rules->add($rules->existsIn(['matiere_id'], 'Matieres'));
        $rules->add($rules->existsIn(['inscription_id'], 'Inscriptions'));

        return $rules;
    }
}
