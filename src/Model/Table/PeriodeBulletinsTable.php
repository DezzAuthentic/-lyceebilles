<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * PeriodeBulletins Model
 *
 * @property \App\Model\Table\PeriodesTable|\Cake\ORM\Association\BelongsTo $Periodes
 * @property \App\Model\Table\AffectationsTable|\Cake\ORM\Association\BelongsTo $Affectations
 * @property \App\Model\Table\PeriodeBulletinLignesTable|\Cake\ORM\Association\HasMany $PeriodeBulletinLignes
 *
 * @method \App\Model\Entity\PeriodeBulletin get($primaryKey, $options = [])
 * @method \App\Model\Entity\PeriodeBulletin newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PeriodeBulletin[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PeriodeBulletin|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PeriodeBulletin|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PeriodeBulletin patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PeriodeBulletin[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PeriodeBulletin findOrCreate($search, callable $callback = null, $options = [])
 */
class PeriodeBulletinsTable extends Table
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

        $this->setTable('periode_bulletins');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Periodes', [
            'foreignKey' => 'periode_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Affectations', [
            'foreignKey' => 'affectation_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('PeriodeBulletinLignes', [
            'foreignKey' => 'periode_bulletin_id'
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
            ->numeric('moyenne')
            ->allowEmpty('moyenne');

        $validator
            ->scalar('appreciation')
            ->maxLength('appreciation', 255)
            ->allowEmpty('appreciation');

        $validator
            ->numeric('moyenne_classe')
            ->allowEmpty('moyenne_classe');

        $validator
            ->numeric('meilleure_moyenne')
            ->allowEmpty('meilleure_moyenne');

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
        $rules->add($rules->existsIn(['periode_id'], 'Periodes'));
        $rules->add($rules->existsIn(['affectation_id'], 'Affectations'));

        return $rules;
    }

    public function calculerBulletins($etablissement_id,$periode_id){
        $groupesTable = TableRegistry::get('Groupes');
        $periodesTable = TableRegistry::get('Periodes');
        $etablissementsTable = TableRegistry::get('Etablissements');
        $lignesTable = TableRegistry::get('PeriodeBulletinLignes');
        $rep = false;

        $periode = $periodesTable->get($periode_id);
        $etablissement = $etablissementsTable->get($etablissement_id);

        $groupes = $groupesTable->find("all",[
            'contain' => ["Affectations.Inscriptions","Cours","Promotions"],
            'conditions' => ["Promotions.annee_id" => $etablissement->annee_id]
        ]);

        foreach ($groupes as $groupe){
            $max=0;
            $i=0;
            $somme_classe=0;
            foreach($groupe->affectations as $affectation){
                $bulletin = $this->find("all",[
                    'conditions' => ['PeriodeBulletins.periode_id' => $periode_id, 'PeriodeBulletins.affectation_id' => $affectation->id]
                ])->first();
                if($bulletin ==null) {
                    $bulletin = $this->newEntity();
                    $bulletin->periode_id = $periode->id;
                    $bulletin->affectation_id = $affectation->id;
                }
                
                if($this->save($bulletin)){
                    $somme=0;
                    $somme_coef = 0; 
                    $moyenne = null;
                    foreach($groupe->cours as $cour){ 
                        $ligne = $lignesTable->enregistrerBulletinLigne($bulletin->id,$cour,$groupe,$periode_id,$affectation->inscription->eleve_id);
                        if ($ligne){
                            if($ligne->note !=null){
                                $somme += $ligne->note*$ligne->coef;
                                $somme_coef += $ligne->coef; 
                            }
                        }    
                    }
                    //Enregistrer la moyenne de l'élève
                    if($somme_coef>0){
                        $moyenne = $somme/$somme_coef;
                        $bulletin->moyenne = $moyenne;
                        if($this->save($bulletin)){
                            $somme_classe +=$moyenne;
                            $i++;
                            $max = $max<$moyenne?$moyenne:$max;
                        }
                    }
                    $rep = $rep and true;
                } else $rep = $rep and false;

            }
            // Enregistrement des moyennes de la classe par matière
            foreach($groupe->cours as $cour){ 
                $lignesTable->enregistrerMoyenneCours($cour->id,$periode_id);
            }
            // Enregistrement de la moyenne de la classe
            foreach($groupe->affectations as $affectation){
                $bulletin = $this->find("all",[
                    'conditions' => ['PeriodeBulletins.periode_id' => $periode_id, 'PeriodeBulletins.affectation_id' => $affectation->id]
                ])->first();
                if($bulletin and $i>0){
                    //dd($somme_classe);
                    $bulletin->moyenne_classe = $somme_classe/$i;
                    $bulletin->meilleure_moyenne = $max;
                    $this->save($bulletin);
                }
            }
        }
        return $rep;
    }
}
