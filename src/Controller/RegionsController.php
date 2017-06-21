<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Regions Controller
 *
 * @property \App\Model\Table\RegionsTable $Regions
 */
class RegionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $regions = $this->paginate($this->Regions);

        $this->set(compact('regions'));
        $this->set('_serialize', ['regions']);
    }

    /**
     * View method
     *
     * @param string|null $id Region id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $region = $this->Regions->get($id, [
            'contain' => ['Clubs']
        ]);

        $this->set('region', $region);
        $this->set('_serialize', ['region']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $region = $this->Regions->newEntity();
        if ($this->request->is('post')) {
            $region = $this->Regions->patchEntity($region, $this->request->data);
            if ($this->Regions->save($region)) {
            	$this->Utilitaire->logInBdd("Ajout de la région : ".$region->id." -> ".$region->name);
                $this->Flash->success(__('La région a été sauvegardée'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('La région ne peut pas être sauvegardée.'));
            }
        }
        $this->set(compact('region'));
        $this->set('_serialize', ['region']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Region id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $region = $this->Regions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $region = $this->Regions->patchEntity($region, $this->request->data);
            if ($this->Regions->save($region)) {
            	$this->Utilitaire->logInBdd("Modification de la région : ".$region->id." -> ".$region->name);
                $this->Flash->success(__('La région a été sauvegardée.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('La région ne peut pas être sauvegardée.'));
            }
        }
        $this->set(compact('region'));
        $this->set('_serialize', ['region']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Region id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
    	if(! $this->Securite->isAdmin()) return $this->redirect(['controller'=>'pages', 'action'=>'permission']);
        $this->request->allowMethod(['post', 'delete']);
        $region = $this->Regions->get($id);
        $message ="Suppression de la région : ".$region->id." -> ".$region->name;
        if ($this->Regions->delete($region)) {
            $this->Flash->success(__('La région a été supprimée.'));
            $this->Utilitaire->logInBdd($message);
        } else {
            $this->Flash->error(__('La région ne peut pas être supprimée.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
