<?php
App::uses('AppController', 'Controller');


 /* Books Controller
 *
 * @property Book $Book
 * @property PaginatorComponent $Paginator
 */
class BooksController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function index() {
            $this->set('books', $this->paginate());
            $this->set('_serialize', array ('books'));
            
        }
        
		
	

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
            if (!$this->Book->exists($id)) {
			throw new NotFoundException(__('Invalid book'));
		}
		
                
                $options = array('conditions' => array('Book.' . $this->Book->primaryKey => $id));
                $this->set('book', $this->Book->find('first', $options));
        
        }           
        

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Book->create();
			if ($this->Book->save($this->request->data)) {
				$this->Session->setFlash(__('The book has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The book could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Book->exists($id)) {
			throw new NotFoundException(__('Invalid book'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Book->save($this->request->data)) {
				$this->Session->setFlash(__('The book has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The book could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Book.' . $this->Book->primaryKey => $id));
			$this->request->data = $this->Book->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Book->id = $id;
		if (!$this->Book->exists()) {
			throw new NotFoundException(__('Invalid book'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Book->delete()) {
			$this->Session->setFlash(__('The book has been deleted.'));
		} else {
			$this->Session->setFlash(__('The book could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
