<?php

namespace App\Controllers;

use App\Middlewares\Auth as AuthMiddware;
use \Core\View;
use App\Repositories\TransportTypeRepository;
use Core\Request;
use App\Auth;

class TransportType extends AuthMiddware
{
    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $transportTypeRepository = new TransportTypeRepository(
            new \App\Models\TransportType
        );
        $items = $transportTypeRepository->getAll();
        $user = Auth::getUser();

        View::renderTemplate(
            'TransportType/index.html',
            ['items' => $items, 'user' => $user]
        );
    }

    /**
     * Create TransportType
     *
     * @return void
     */
    public function create()
    {
        $this->isAdmin();
        $name = $_POST['name'];
        $transportTypeRepository = new TransportTypeRepository(
            new \App\Models\TransportType
        );
        $error = $this->validation($name, $transportTypeRepository);

        if (empty($error)) {
            $transportTypeRepository->create($name);
            $this->redirect('/transportType');
        } else {
            View::renderTemplate(
                'TransportType/create.html',
                [
                    'error' => $error,
                    'name' => $name
                ]
            );
        }

    }

    /**
     * Update TransportType
     *
     * @return void
     */
    public function update()
    {
        $this->isAdmin();
        $data = $_POST;
        $transportTypeRepository = new TransportTypeRepository(
            new \App\Models\TransportType
        );
        $error = $this->validation($data['name'], $transportTypeRepository);

        if (!empty($error)) {
            $transportTypeRepository->update($data['id'], $data['name']);
            $item = $transportTypeRepository->getById($data['id']);
            $this->redirect('TransportType/update.html', ['item' => $item]);
        } else {
            View::renderTemplate(
                'TransportType/update.html',
                [
                    'errors' => $error,
                    'item' => [
                        'name' => $data['name'],
                        'id' => $data['id']
                    ]
                ]
            );
        }
    }

    /**
     * Delete TransportType
     *
     * @return void
     */
    public function delete()
    {
        $this->isAdmin();
        $data = file_get_contents("php://input");
        $id = explode('=', $data)[1];
        
        $transportTypeRepository = new TransportTypeRepository(
            new \App\Models\TransportType
        );
        $transportTypeRepository->delete($id);
    }

    /**
     * Validate credentials for TransportType
     *
     * @param string                  $name
     * @param TransportTypeRepository $transportTypeRepository
     * 
     * @return void
     */
    public function validation(
        string $name,
        TransportTypeRepository $transportTypeRepository
    ) {
        if (empty($name)) {
            return 'Name is required';
        }
        
        if ($transportTypeRepository->nameExists($name)) {
            return 'Name already taken';
        }

    }

    /**
     * Show the update page
     * 
     * @param Request $request
     *
     * @return void
     */
    public function updatePage(Request $request)
    {
        $this->isAdmin();
        $transportTypeRepository = new TransportTypeRepository(
            new \App\Models\TransportType
        );
        $item = $transportTypeRepository->getById($request->params[0]);

        View::renderTemplate(
            'TransportType/update.html',
            ['item' => $item]
        );
    }

    /**
     * Show the create page
     *
     * @return void
     */
    public function createPage()
    {
        $this->isAdmin();
        View::renderTemplate(
            'TransportType/create.html'
        );
    }

    /**
     * Show the show page
     * 
     * @param Request $request
     *
     * @return void
     */
    public function show(Request $request)
    {
        $transportTypeRepository = new TransportTypeRepository(
            new \App\Models\TransportType
        );
        $item = $transportTypeRepository->getById($request->params[0]);
        if ($item) {
            View::renderTemplate('TransportType/show.html', ['name' => $item->name]);
        } else {
            $this->redirect('/transportType');
        }
    }
    
    /**
     * Check auth user is admin
     *
     * @return bool|void
     */
    public function isAdmin()
    {
        $user = Auth::getUser();
        if ($user->role_id == 2) {
            $this->redirect('/transportType');
            return false;
        }
    }
}
