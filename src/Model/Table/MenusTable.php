<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Menus Model
 *
 * @property \App\Model\Table\PlatsTable|\Cake\ORM\Association\BelongsTo $Plats
 * @property \App\Model\Table\DessertsTable|\Cake\ORM\Association\BelongsTo $Desserts
 *
 * @method \App\Model\Entity\Menu get($primaryKey, $options = [])
 * @method \App\Model\Entity\Menu newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Menu[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Menu|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Menu|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Menu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Menu[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Menu findOrCreate($search, callable $callback = null, $options = [])
 */
class MenusTable extends Table
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

        $this->setTable('menus');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Plats', [
            'foreignKey' => 'plat_id'
        ]);
        $this->belongsTo('Desserts', [
            'foreignKey' => 'dessert_id'
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
            ->scalar('jour')
            ->maxLength('jour', 11)
            ->allowEmpty('jour');

        $validator
            ->allowEmpty('type');

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
        $rules->add($rules->existsIn(['plat_id'], 'Plats'));
        $rules->add($rules->existsIn(['dessert_id'], 'Desserts'));

        return $rules;
    }

    public function init(){
        $this->deleteAll([true]);
        $jours = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
        foreach($jours as $jour){
            for($i=1;$i<=4;$i++){
                $menu = $this->newEntity();
                $menu->jour = $jour;
                $menu->type = $i;
                $menu->template_id =1;
                $this->save($menu);
            }
            for($i=1;$i<=4;$i++){
                $menu = $this->newEntity();
                $menu->jour = $jour;
                $menu->type = $i;
                $menu->template_id =2;
                $this->save($menu);
            }
        }
    }
}
