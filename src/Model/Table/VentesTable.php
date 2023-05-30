<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ventes Model
 *
 * @property \App\Model\Table\EtablissementsTable|\Cake\ORM\Association\BelongsTo $Etablissements
 * @property \App\Model\Table\ElevesTable|\Cake\ORM\Association\BelongsTo $Eleves
 * @property \App\Model\Table\VLignesTable|\Cake\ORM\Association\HasMany $VLignes
 *
 * @method \App\Model\Entity\Vente get($primaryKey, $options = [])
 * @method \App\Model\Entity\Vente newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Vente[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Vente|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vente|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vente patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Vente[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Vente findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class VentesTable extends Table
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

        $this->setTable('ventes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Etablissements', [
            'foreignKey' => 'etablissement_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Eleves', [
            'foreignKey' => 'eleve_id'
        ]);
        $this->hasMany('VLignes', [
            'foreignKey' => 'vente_id'
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
            ->allowEmpty('status');

        $validator
            ->numeric('total')
            ->allowEmpty('total');

        $validator
            ->numeric('paye')
            ->allowEmpty('paye');

        $validator
            ->numeric('restant')
            ->allowEmpty('restant');

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
        $rules->add($rules->existsIn(['etablissement_id'], 'Etablissements'));
        $rules->add($rules->existsIn(['eleve_id'], 'Eleves'));

        return $rules;
    }

}
