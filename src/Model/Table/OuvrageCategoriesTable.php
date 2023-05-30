<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OuvrageCategories Model
 *
 * @method \App\Model\Entity\OuvrageCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\OuvrageCategory newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OuvrageCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OuvrageCategory|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OuvrageCategory|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OuvrageCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OuvrageCategory[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OuvrageCategory findOrCreate($search, callable $callback = null, $options = [])
 */
class OuvrageCategoriesTable extends Table
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

        $this->setTable('ouvrage_categories');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmpty('description');

        return $validator;
    }
}
