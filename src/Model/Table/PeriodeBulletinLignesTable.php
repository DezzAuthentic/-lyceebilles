<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * PeriodeBulletinLignes Model
 *
 * @property \App\Model\Table\PeriodeBulletinsTable|\Cake\ORM\Association\BelongsTo $PeriodeBulletins
 * @property \App\Model\Table\CoursTable|\Cake\ORM\Association\BelongsTo $Cours
 *
 * @method \App\Model\Entity\PeriodeBulletinLigne get($primaryKey, $options = [])
 * @method \App\Model\Entity\PeriodeBulletinLigne newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PeriodeBulletinLigne[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PeriodeBulletinLigne|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PeriodeBulletinLigne|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PeriodeBulletinLigne patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PeriodeBulletinLigne[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PeriodeBulletinLigne findOrCreate($search, callable $callback = null, $options = [])
 */
class PeriodeBulletinLignesTable extends Table
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

        $this->setTable('periode_bulletin_lignes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PeriodeBulletins', [
            'foreignKey' => 'periode_bulletin_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Cours', [
            'foreignKey' => 'cours_id',
            'joinType' => 'INNER'
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
            ->numeric('note')
            ->allowEmpty('note');

        $validator
            ->numeric('composition_note')
            ->allowEmpty('composition_note');

        $validator
            ->integer('coef')
            ->allowEmpty('coef');

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
        $rules->add($rules->existsIn(['periode_bulletin_id'], 'PeriodeBulletins'));
        $rules->add($rules->existsIn(['cours_id'], 'Cours'));

        return $rules;
    }

    public function enregistrerBulletinLigne($bulletin_id,$cours,$groupe,$periode_id,$eleve_id){
        $devoirNotesTable = TableRegistry::get('DevoirNotes');
        $coefficientsTable = TableRegistry::get('Coefficients');
        $promotionsTable = TableRegistry::get('Promotions');

        $cours_id = $cours->id;
        //calcul de la note
        $notes = $devoirNotesTable->find('all',[
            "contain" => ["Devoirs"],
            "conditions" => ["Devoirs.periode_id" => $periode_id, "Devoirs.Cours_id" => $cours_id, "DevoirNotes.eleve_id" => $eleve_id]
        ]);
        $note = 0;
        foreach($notes as $not){
            $note += $not->note;
        }
        $note = $notes->count()>0?$note/$notes->count():null;
        //récupération du coefficient
        $promotion = $promotionsTable->get($groupe->promotion_id);
        $coefficient = $coefficientsTable->find('all',[
            'conditions' => ['Coefficients.matiere_id' => $cours->matiere_id,'Coefficients.niveau_id' => $promotion->niveau_id, 'Coefficients.serie_id IS' => $promotion->serie_id]
        ])->first();

        $coef = $coefficient!=null?$coefficient->coef:1;

        //Enregistrement de la ligne 
        $ligne = $this->find('all',[
            'conditions' => ['PeriodeBulletinLignes.periode_bulletin_id' => $bulletin_id, 'PeriodeBulletinLignes.cours_id' => $cours_id] 
        ])->first();       
        if($ligne ==null) {
            $ligne = $this->newEntity();
            $ligne->periode_bulletin_id = $bulletin_id;
            $ligne->cours_id = $cours_id;
        }
        $ligne->note = $note;
        $ligne->coef = $coef;
        if($this->save($ligne)){
            return $ligne;
        } else return false;
    }

    public function enregistrerMoyenneCours($cours_id,$periode_id){
        $lignes = $this->find('all',[
            'contain' => ['PeriodeBulletins'],
            'conditions' => ['PeriodeBulletins.periode_id' => $periode_id, 'PeriodeBulletinLignes.cours_id' => $cours_id] 
        ]);
        $moyenne = null;
        $max = 0;
        $somme = 0;
        $i=0;
        foreach($lignes as $ligne){
            if($ligne->note !=null){
                $somme += $ligne->note;
                $i++; 
                $max = $max<$ligne->note?$ligne->note:$max;
            }
        }
        if($i>0) $moyenne = $somme/$i;
        foreach($lignes as $ligne){
            $ligne->moyenne_classe = $moyenne;
            $ligne->meilleure_moyenne = $max;
            $this->save($ligne);
        }
    }
}
