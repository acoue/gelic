<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Clubs Controller
 *
 * @property \App\Model\Table\ClubsTable $Clubs
 */
class ClubsController extends AppController
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
            'contain' => ['Regions']
        ];
        $clubs = $this->paginate($this->Clubs);

        $this->set(compact('clubs'));
        $this->set('_serialize', ['clubs']);
    }

    /**
     * View method
     *
     * @param string|null $id Club id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $club = $this->Clubs->get($id, [
            'contain' => ['Regions', 'Licencies']
        ]);

        $this->set('club', $club);
        $this->set('_serialize', ['club']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $club = $this->Clubs->newEntity();
        if ($this->request->is('post')) {
            $club = $this->Clubs->patchEntity($club, $this->request->data);
            if ($this->Clubs->save($club)) {
            	$this->Utilitaire->logInBdd("Ajout du club : ".$club->id." -> ".$club->name);
                $this->Flash->success(__('Le club a été sauvegardé.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Le club n\'a pas été sauvegardé.'));
            }
        }
        $regions = $this->Clubs->Regions->find('list');
        $this->set(compact('club', 'regions'));
        $this->set('_serialize', ['club']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Club id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $club = $this->Clubs->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $club = $this->Clubs->patchEntity($club, $this->request->data);
            if ($this->Clubs->save($club)) {
            	$this->Utilitaire->logInBdd("Modification du club : ".$club->id." -> ".$club->name);
                $this->Flash->success(__('Le club a été sauvegardé.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Le club n\'a pas été sauvegardé.'));
            }
        }
        $regions = $this->Clubs->Regions->find('list', ['limit' => 200]);
        $this->set(compact('club', 'regions'));
        $this->set('_serialize', ['club']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Club id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $this->request->allowMethod(['post', 'delete']);
        $club = $this->Clubs->get($id);
        $message ="Suppression du club : ".$club->id." -> ".$club->name;
        if ($this->Clubs->delete($club)) {
            $this->Flash->success(__('Le club a été supprimé.'));
            $this->Utilitaire->logInBdd($message);
        } else {
            $this->Flash->error(__('Le club n\'a pas été supprimé.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
