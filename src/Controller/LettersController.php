<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;





/**
 * Letters Controller
 *
 * @property \App\Model\Table\LettersTable $Letters
 */
class LettersController extends AppController
{



    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
	 
	 public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Security');
        $this->loadComponent('Search.Prg', [
            // This is default config. You can modify "actions" as needed to make
            // the PRG component work only for specified methods.
            'actions' => ['index']
        ]);

        //$letters = TableRegistry::get('Letters');
        //$letters->recover();
        Time::setDefaultLocale('fr-FR');

        Time::setJsonEncodeFormat('dd-MM-yyyy HH:mm:ss');
    }
    public function beforeFilter(Event $event)
{
    //parent::beforeFilter($event);
	$this->Security->config('unlockedActions', ['add','index']);
	
}


    /**
     *
     */
    public function index()
    {
        $query = $this->Letters
            // Use the plugins 'search' custom finder and pass in the
            // processed query params
            ->find('search', ['search' => $this->request->query])
            // You can add extra things to the query if you need to
            ;
        //debug($this->request->data('tags._ids'));
        $tag_ids=explode(',',$this->request->data('tags._ids'));
        $this->set('letters', $this->paginate($query));



        //$letters = $this->paginate($this->Letters);
        $tags = $this->Letters->Tags->find('list', ['limit' => 200]);

        //$tags2 = $this->Letters->Tags->find('list', ['limit' => 200]);

        //print_r($tags2);
        $this->set(compact( 'tags'));
        $this->set('tag_ids',$tag_ids);

       
    }

    /**
     * View method
     *
     * @param string|null $id Letter id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $letter = $this->Letters->get($id, [
            'contain' => ['Tags','parentLetter']
        ]);

        $query = $this->Letters->find('path',['for' => $letter->id]);



         //debug($output);


        $this->set('answers',$query->toArray());

        $this->set('letter', $letter);
        $this->set('_serialize', ['letter']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
	
    {
		$query=$this->Letters->Tags->find()->all();
		foreach ($query as $temp){
			$liste_tags[]= $temp['name'];
		}
		$letter = $this->Letters->newEntity();

        if ($this->request->is('post')) {

			$letter = $this->Letters->patchEntity($letter, $this->request->data);
			//debug($letter);

					if ($this->Letters->save($letter)) {
						$this->Flash->success(__('The letter has been saved.'));

                        $withoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $letter['file']);
                        $commande='"C:\Program Files\ImageMagick-7.0.3-Q16\convert.exe" "G:\WAMP64\WWW\managecourier\webroot\files\Letters\file\\'.$letter['file'].'[0]" -colorspace RGB -geometry 200 "G:\WAMP64\WWW\managecourier\webroot\files\Letters\file\\'.$withoutExt.'.png"  2>&1';
                        //debug($commande);
                        shell_exec('cd "C:\Program Files\ImageMagick-7.0.3-Q16" & C:  &'. $commande.' 2>&1');

						//return $this->redirect(['action' => 'index']);
					} else {
						
							//debug($letter->errors());
						//$this->Flash->error(__('The letter could not be saved. Please, try again.'));
					}
			
        }
        
		$tags = $this->Letters->Tags->find('list', ['limit' => 200]);
		$this->set('_serialize', ['letter']);
        $this->set(compact('letter', 'tags'));
        $this->set('liste_tags', $liste_tags);
        $this->set('letters', $this->Letters->find('list',
            [ 'keyField' => 'id', 'valueField' => 'reference' ]));
    }

    /**
     * Edit method
     *
     * @param string|null $id Letter id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $letter = $this->Letters->get($id, [
            'contain' => ['Tags']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $letter = $this->Letters->patchEntity($letter, $this->request->data);
            if ($this->Letters->save($letter)) {
                $this->Flash->success(__('The letter has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The letter could not be saved. Please, try again.'));
            }
        }
        $tags = $this->Letters->Tags->find('list', ['limit' => 200]);
        $this->set(compact('letter', 'tags'));
        $this->set('_serialize', ['letter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Letter id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $letter = $this->Letters->get($id);
        if ($this->Letters->delete($letter)) {
            $this->Flash->success(__('The letter has been deleted.'));
        } else {
            $this->Flash->error(__('The letter could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }



}
