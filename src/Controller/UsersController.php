<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Cake\Http\Exception\NotFoundException;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AbstractController
{

    const MIN_PASSWORD_LEN = 6;

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if ($this->Auth->isAdmin()) {
            $users = $this->paginate($this->Users);

            $this->set(compact('users'));
        } else {
            throw new NotFoundException();
        }
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if (is_null($id) || !($this->Auth->isAdmin())) {
            throw new NotFoundException();
        }
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if (!$this->Auth->isAdmin()) {
            throw new NotFoundException();
        }

        $authorities = $this->getAuthorities();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $password = $data['password'];
            if (strlen($password) < self::MIN_PASSWORD_LEN) {
                $this->flashError('E00003');
            }
            $data['password'] = hash('sha256', $password);
            $data['created_by'] = $this->Auth->User('account');
            $data['updated_by'] = $this->Auth->User('account');
            $user = $this->Users->newEmptyEntity();
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('authorities'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $isAdmin = $this->Auth->isAdmin();
        if (is_null($id) || !($isAdmin) && $id !== $this->Auth->User('account')) {
            throw new NotFoundException();
        }
        $user = $this->Users->get($id);

        // Adminユーザの場合権限変更を許容させるため一覧取得
        $authorities = [];
        if ($isAdmin) {
            $authorities = $this->getAuthorities();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // 権限設定はAdmin権限のみ許容する
            if (!$this->Auth->isAdmin() && isset($data['auth_name'])) {
                $this->flashError("E00008");
            }

            $account = $this->Auth->User('account');
            if (isset($data['auth_name'])) {
                $user->edit($account, $data['nickname'], $data['auth_name']);
            } else {
                $user->edit($account, $data['nickname']);
            }

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                // 自身のニックネームを変更した場合はヘッダに表示する値を即時変更するため
                // セッションを更新する
                if ($account === $id) {
                    $this->getRequest()->getSession()->write('User.nickname', $user->nickname);
                }
                return $this->redirect(['controller' => 'top', 'action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

        $this->set(compact('user', 'isAdmin', 'authorities'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if (is_null($id) || !$this->Auth->isAdmin()) {
            throw new NotFoundException();
        }
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Change Password Method
     * 
     * @param string|null $id User id
     * @return \Cake\Http\Response|null|void Redirects to index.
     */
    public function changePassword($id=null) {
        if (is_null($id) || $this->Auth->User('account') !== $id) {
            throw new NotFoundException();
        }

        if ($this->request->is(['post'])) {
            $data = $this->request->getData();
            $oldPassword = $data['old_password'];
            $newPassword1 = $data['new_password1'];
            $newPassword2 = $data['new_password2'];
            if ($this->Str->hasNullOrEmpty([$oldPassword, $newPassword1, $newPassword2])) {
                $this->flashError('E00004');
                return;
            };

            $user = $this->Users->get($id);
            if (hash('sha256', $oldPassword) !== $user->password) {
                $this->flashError('E00005');
                return;
            }

            if ($newPassword1 !== $newPassword2) {
                $this->flashError('E00006');
                return;
            }

            if (strlen($newPassword1) < self::MIN_PASSWORD_LEN) {
                $this->flashError('E00003');
                return;
            }

            if ($newPassword1 === $oldPassword) {
                $this->flashError('E00007');
                return;
            }

            $user->changePassword($newPassword1);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['controller' => 'top', 'action' => 'index']);
            }

            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }

    }

    /**
     * Reset Password Method
     * 
     * @return \Cake\Http\Response|null|void Redirects to index.
     */
    public function resetPassword() {
        if (!$this->Auth->isAdmin() || !$this->request->is(['post'])) {
            throw new NotFoundException();
        }

        $data = $this->request->getData();
        $account = $data['account'];
        $password = $data['password'];

        // 入力チェック
        if ($this->Str->hasNullOrEmpty([$account, $password])) {
            $this->flashError('E00004');
            return;
        };
        if (strlen($password) < self::MIN_PASSWORD_LEN) {
            $this->flashError('E00003');
            return;
        }

        $user = $this->Users->get($account);
        $user->changePassword($password, $this->Auth->User('account'));

        if ($this->Users->save($user)) {
            $this->Flash->success(__('The user has been saved.'));

            return $this->redirect(['controller' => 'top', 'action' => 'index']);
        }

        $this->Flash->error(__('The user could not be saved. Please, try again.'));

    }

    /**
     * 権限一覧取得
     */
    private function getAuthorities(): Query {
        $authoritiesTable = TableRegistry::getTableLocator()->get('Authorities');
        return $authoritiesTable->find()->select(['auth_name'])->order(['auth_name' => 'DESC']);
    }
}
