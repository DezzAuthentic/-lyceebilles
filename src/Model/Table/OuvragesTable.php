<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ouvrages Model
 *
 * @property \App\Model\Table\OuvrageCategoriesTable|\Cake\ORM\Association\BelongsTo $OuvrageCategories
 * @property \App\Model\Table\EmpruntsTable|\Cake\ORM\Association\HasMany $Emprunts
 *
 * @method \App\Model\Entity\Ouvrage get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ouvrage newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ouvrage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ouvrage|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ouvrage|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ouvrage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ouvrage[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ouvrage findOrCreate($search, callable $callback = null, $options = [])
 */
class OuvragesTable extends Table
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

        $this->setTable('ouvrages');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('OuvrageCategories', [
            'foreignKey' => 'ouvrage_categorie_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Emprunts', [
            'foreignKey' => 'ouvrage_id'
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
            ->scalar('titre')
            ->maxLength('titre', 255)
            ->allowEmpty('titre');

        $validator
            ->scalar('resume')
            ->allowEmpty('resume');

        $validator
            ->integer('quantite')
            ->allowEmpty('quantite');

        $validator
            ->scalar('type')
            ->maxLength('type', 45)
            ->allowEmpty('type');

        $validator
            ->scalar('pj')
            ->maxLength('pj', 255)
            ->allowEmpty('pj');

        $validator
            ->integer('en_pret')
            ->allowEmpty('en_pret');

        $validator
            ->scalar('rangement')
            ->maxLength('rangement', 45)
            ->allowEmpty('rangement');

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
        $rules->add($rules->existsIn(['ouvrage_categorie_id'], 'OuvrageCategories'));

        return $rules;
    }
}
