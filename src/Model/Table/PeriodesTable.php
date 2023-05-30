<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Periodes Model
 *
 * @property \App\Model\Table\AnneesTable|\Cake\ORM\Association\BelongsTo $Annees
 * @property |\Cake\ORM\Association\HasMany $Devoirs
 * @property \App\Model\Table\PeriodeBulletinsTable|\Cake\ORM\Association\HasMany $PeriodeBulletins
 *
 * @method \App\Model\Entity\Periode get($primaryKey, $options = [])
 * @method \App\Model\Entity\Periode newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Periode[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Periode|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Periode|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Periode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Periode[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Periode findOrCreate($search, callable $callback = null, $options = [])
 */
class PeriodesTable extends Table
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

        $this->setTable('periodes');
        $this->setDisplayField('nom');
        $this->setPrimaryKey('id');

        $this->belongsTo('Annees', [
            'foreignKey' => 'annee_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Devoirs', [
            'foreignKey' => 'periode_id'
        ]);
        $this->hasMany('PeriodeBulletins', [
            'foreignKey' => 'periode_id'
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
            ->date('debut')
            ->allowEmpty('debut');

        $validator
            ->date('fin')
            ->allowEmpty('fin');

        $validator
            ->scalar('statut')
            ->maxLength('statut', 10)
            ->allowEmpty('statut');

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
        $rules->add($rules->existsIn(['annee_id'], 'Annees'));

        return $rules;
    }

    /*public function afterSave($event){
        $periode = $event->getData()['entity'];
        $BulletinsTable = TableRegistry::get('PeriodeBulletin');
        
        if($periode->statut == 'cloturé'){
            $BulletinsTable->calculerBulletins($etablissement_id,$periode_id)
        }
    }*/

}
