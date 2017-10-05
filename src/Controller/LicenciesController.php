<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;

/**
 * Licencies Controller
 *
 * @property \App\Model\Table\LicenciesTable $Licencies
 */
class LicenciesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $this->paginate = [
            'contain' => ['Clubs']
        ];
        $licencies = $this->paginate($this->Licencies);

        $this->set(compact('licencies'));
        $this->set('_serialize', ['licencies']);
    }

    public function liste()
    {
        if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $this->paginate = [
            'contain' => ['Clubs']
        ];
        $licencies = $this->paginate($this->Licencies,['limit' => 50]);
        
        $this->set(compact('licencies'));
        $this->set('_serialize', ['licencies']);
    }
    
    public function export()
    {
        if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        
        
        $licencies = $this->Licencies->find()->contain(['Clubs'=>['Regions'],'Disciplines','Grades']);
        
        $filename = date('Y-m-d_his') . "_export_licencies.csv";
        $file = new File(TMP_FILES . $filename, true, 0644);
        $file->create();
        $file->write('"Prénom";"nom";"sexe";"ddn";"licence";"discipline";"grade";"club";"region";');
        $file->write("\n");
        
        foreach ($licencies as $licencie) {
            $file->write('"');
            $file->write($licencie->prenom);
            $file->write('";"');
            $file->write($licencie->nom);
            $file->write('";"');
            $file->write($licencie->sexe);
            $file->write('";"');
            $file->write($licencie->ddn);
            $file->write('";"');
            $file->write($licencie->licence);
            $file->write('";"');
            $file->write($licencie->discipline->name);
            $file->write('";"');
            $file->write($licencie->grade->name);
            $file->write('";"');
            $file->write($licencie->club->name);
            $file->write('";"');
            $file->write($licencie->club->region->name);
            $file->write('";');
            $file->write("\n");
        }
        
        $file->close();
        $this->autoRender = false;
        $this->response->type('application/csv');
        $this->response->file(TMP_FILES . $filename, ['download' => true, 'name' => $filename]);
        return $this->response;
        
//         header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//         header('Content-Description: File Transfer');
//         header("Content-type: text/csv");
//         header("Content-Disposition: attachment; filename={$fileName}");
//         header("Expires: 0");
//         header("Pragma: public");
    }
    
    
    
    
    /**
     * View method
     *
     * @param string|null $id Licency id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $licency = $this->Licencies->get($id, [
            'contain' => ['Clubs','Disciplines','Grades']
        ]);

        $this->set('licency', $licency);
        $this->set('_serialize', ['licency']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $licency = $this->Licencies->newEntity();
        if ($this->request->is('post')) {
        	$data=$this->request->data;
        	//debug($data);die();
            $licency = $this->Licencies->patchEntity($licency, $data);
            $licency->display_name = $data['prenom']." ".$data['nom'];
            
            $dateNaissance=$data['ddn'];
            //Transformation de la date : dd/mm/yyyy vers yyyy-mm-dd
            if(strlen($dateNaissance) > 0) {
            	$tmp_date = $dateNaissance;
            	$dateNaissance = substr($tmp_date, 6,4)."-".substr($tmp_date, 3,2)."-".substr($tmp_date, 0,2);
            } else $dateNaissance=null;
            $licency->ddn = $dateNaissance;
            
            //debug($licency); die();
            
            if ($this->Licencies->save($licency)) {
                $this->Flash->success(__('Le licencié a été sauvegardé.'));
            	$this->Utilitaire->logInBdd("Ajout du licencié : ".$licency->id." -> ".$licency->display_name." - Club : ".$licency->club_id." - Discipline : ".$licency->discipline_id);
                return $this->redirect(['action' => 'liste']);
            } else {
                $this->Flash->error(__('Le licencié n\'a pas été sauvegardé.'));
            }
        }
        $clubs = $this->Licencies->Clubs->find('list');
        $grades = $this->Licencies->Grades->find('list');
        $disciplines = $this->Licencies->Disciplines->find('list');
        $this->set(compact('licency', 'clubs','grades','disciplines'));
        $this->set('_serialize', ['licency']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Licency id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $licency = $this->Licencies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
        	$data=$this->request->data;
        	
            $licency = $this->Licencies->patchEntity($licency, $data);
            $licency->display_name = $data['prenom']." ".$data['nom'];

            $dateNaissance=$data['ddn'];
            //Transformation de la date : dd/mm/yyyy vers yyyy-mm-dd
            if(isset($dateNaissance)) {
            	$tmp_date = $dateNaissance;
            	$dateNaissance = substr($tmp_date, 6,4)."-".substr($tmp_date, 3,2)."-".substr($tmp_date, 0,2);
            }
            $licency->ddn = $dateNaissance;
            //debug($licency);
            if ($this->Licencies->save($licency)) {
                $this->Flash->success(__('Le licencié a été sauvegardé.'));
            	$this->Utilitaire->logInBdd("Modification du licencié : ".$licency->id." -> ".$licency->display_name." - Club : ".$licency->club_id." - Discipline : ".$licency->discipline_id);
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Le licencié n\'a pas été sauvegardé.'));
            }
        }
        $clubs = $this->Licencies->Clubs->find('list');
        $disciplines = $this->Licencies->Disciplines->find('list');
        $grades = $this->Licencies->Grades->find('list');
        $this->set(compact('licency', 'clubs','grades','disciplines'));
        $this->set('_serialize', ['licency']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Licency id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $this->request->allowMethod(['post', 'delete']);
        $licency = $this->Licencies->get($id);
        $message = "Suppression du licencié : ".$licency->id." -> ".$licency->display_name." - Club : ".$licency->club_id." - Discipline : ".$licency->discipline_id;
                
        if ($this->Licencies->delete($licency)) {
            $this->Flash->success(__('Le licencié a été supprimé.'));
            $this->Utilitaire->logInBdd($message);
        } else {
            $this->Flash->error(__('Le licencié n\'a pas été sauvegardé.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    public function search() {
    	if ($this->request->is(['ajax'])) {
    		$libelle = $this->request->data['libelle'];    		
    		
    		$lic = $this->Licencies->find('all')
    		->contain(['Clubs'])
    		->limit(20)
    		->where(['prenom like '=>'%'.$libelle.'%'])
    		->orWhere(['nom like '=>'%'.$libelle.'%']);
    		
    		$this->set('licencies', $lic);
    
    		//% or name like %% or description like %%
    	}
    }
}
