<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Configurations Model
 *
 * @property \App\Model\Table\EtablissementsTable|\Cake\ORM\Association\HasMany $Etablissements
 *
 * @method \App\Model\Entity\Configuration get($primaryKey, $options = [])
 * @method \App\Model\Entity\Configuration newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Configuration[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Configuration|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Configuration|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Configuration patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Configuration[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Configuration findOrCreate($search, callable $callback = null, $options = [])
 */
class ConfigurationsTable extends Table
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

        $this->setTable('configurations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Etablissements', [
            'foreignKey' => 'configuration_id'
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
            ->integer('professeur_acces')
            ->allowEmpty('professeur_acces');

        $validator
            ->integer('eleve_acces')
            ->allowEmpty('eleve_acces');

        $validator
            ->integer('tuteur_acces')
            ->allowEmpty('tuteur_acces');

        $validator
            ->integer('notification_email')
            ->allowEmpty('notification_email');

        $validator
            ->integer('notification_sms')
            ->allowEmpty('notification_sms');

        return $validator;
    }
}
